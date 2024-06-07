<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'DESC')->with('user', 'applications')->paginate(10);
        return view('admin.jobs.list', [
            'jobs' => $jobs
        ]);
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);

        $categories = Category::orderBy('name', 'ASC')->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->get();

        return view('admin.jobs.edit', [
            'job' => $job,
            'categories' => $categories,
            'jobTypes' => $jobTypes,
        ]);
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id  = $request->jobType;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;

            $job->status = $request->status;
            $job->isFeatured = (!empty($request->isFeatured)) ? $request->isFeatured : 0;
            $job->save();

            session()->flash('success', 'Job updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function destroy(Request $request)
    {
        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error', 'Either job deleted or not found');
            return response()->json([
                'status' => false
            ]);
        }

        $job->delete();
        session()->flash('success', 'Job deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }

    public function createCategory(Request $request)
    {

        return view('admin.category.create');
    }
    public function saveCategory(Request $request)
    {

        $rules = [
            'category' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $job = new Category();
            $job->name = $request->category;
            $job->save();

            session()->flash('success', 'Job added successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function categories()
    {
        $categories = Category::paginate(10);
        return view('admin.category.list', compact('categories'));
    }
    public function editCategories($id)
    {
        $category = Category::findOrFail($id);


        return view('admin.category.edit', [
            'category' => $category,
        ]);
    }
    public function updateCategories(Request $request, $id)
    {

        $rules = [
            'category' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $category = Category::find($id);
            $category->name = $request->category;
            $category->save();

            session()->flash('success', 'Category updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroyCategories(Request $request)
    {
        $id = $request->id;

        $category = Category::find($id);

        if ($category == null) {
            session()->flash('error', 'Either category deleted or not found');
            return response()->json([
                'status' => false
            ]);
        }

        $category->delete();
        session()->flash('success', 'Category deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }

    public function createType(Request $request)
    {

        return view('admin.job-type.create');
    }
    public function saveType(Request $request)
    {

        $rules = [
            'type' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $type = new JobType();
            $type->name = $request->type;
            $type->save();

            session()->flash('success', 'Type added successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function types()
    {
        $types = JobType::paginate(10);
        return view('admin.job-type.list', compact('types'));
    }
    public function editTypes($id)
    {
        $type = JobType::findOrFail($id);


        return view('admin.job-type.edit', [
            'type' => $type,
        ]);
    }
    public function updateTypes(Request $request, $id)
    {

        $rules = [
            'type' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $type = JobType::find($id);
            $type->name = $request->type;
            $type->save();

            session()->flash('success', 'JobType updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroyTypes(Request $request)
    {
        $id = $request->id;

        $type = JobType::find($id);

        if ($type == null) {
            session()->flash('error', 'Either JobType deleted or not found');
            return response()->json([
                'status' => false
            ]);
        }

        $type->delete();
        session()->flash('success', 'Type deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}
