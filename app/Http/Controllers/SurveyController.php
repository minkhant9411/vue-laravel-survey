<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SurveyController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $user = $request->user();
        return SurveyResource::collection(Survey::where('user_id', $user->id)->paginate(4));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSurveyRequest $request) {
        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }
        $survey =  Survey::create($data);
        foreach ($data['questions'] as $question) {
            $question['survey_id'] = $survey->id;
            $this->createQuestion($question);
        }
        return new SurveyResource($survey);
    }

    private function createQuestion($question) {
        if (is_array($question['data'])) {
            $question['data'] = json_encode($question['data']);
        }
        $validator = Validator::make($question, [
            'question' => 'required|string',
            'type' => ['required', Rule::in([
                'text',
                'textarea',
                'select',
                'radio',
                'checkbox'
            ])],
            'description' => 'nullable|string',
            'data' => 'present',
            'survey_id' => 'exists:surveys,id'
        ]);
        return SurveyQuestion::create($validator->validated());
    }
    /**
     * Display the specified resource.
     */
    public function show(Survey $survey, Request $request) {
        $user = $request->user();
        if ($user->id !== $survey->user_id) {
            return abort(403, "Unauthorized action.");
        }
        return new SurveyResource($survey);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyRequest $request, Survey $survey) {

        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
            if ($survey->image) {
                $absolutePuth = public_path($survey->image);
                File::delete($absolutePuth);
            }
        }
        $survey->update($data);
        // return new SurveyResource($survey);
        //get ids of existeing questions
        $existingIds = $survey->questions()->pluck('id')->toArray();

        //get ids of new questions
        $newIds = Arr::pluck($data['questions'], 'id');

        //find questions to delete

        $toDelete = array_diff($existingIds, $newIds);

        //find questions to add

        $toAdd = array_diff($newIds, $existingIds);

        //delete questions that are remove 
        SurveyQuestion::destroy($toDelete);

        //create new questions
        foreach ($data['questions'] as $question) {
            if (in_array($question['id'], $toAdd)) {
                $question['survey_id'] = $survey->id;
                $this->createQuestion($question);
            }
        }

        //update existeing questions
        $questionMap = collect($data['questions'])->keyBy('id');
        foreach ($survey->questions as $question) {

            if (isset($questionMap[$question->id])) {
                $this->updateQuestion($question, $questionMap[$question->id]);
            }
        }
        return new SurveyResource($survey);
    }
    private function updateQuestion(SurveyQuestion $question, $data) {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
            $validator = Validator::make($data, [
                'id' => 'exists:survey_questions,id',
                'question' => 'required|string',
                'type' => ['required', Rule::in([
                    'text',
                    'textarea',
                    'select',
                    'radio',
                    'checkbox'
                ])],
                'description' => 'nullable|string',
                'data' => 'present'
            ]);
            return $question->update($validator->validated());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey, Request $request) {

        $user = $request->user();
        if ($user->id !== $survey->user_id) {
            return abort(403, "Unauthorized action.");
        }
        $survey->delete();
        return response(['', 204]);
    }

    private function saveImage($img) {
        if (preg_match('/^data:image\/(\w+);base64,/', $img, $type)) {
            $img = substr($img, strpos($img, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception("invalid image type");
            }
            $img = str_replace('', '+', $img);
            $img = base64_decode($img);
            if (!$img) {
                throw new \Exception('base64decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }
        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $img);

        return $relativePath;
    }
}
