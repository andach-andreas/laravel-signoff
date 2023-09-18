<?php

namespace Andach\LaravelSignoff\Controllers;

use Andach\LaravelSignoff\Interfaces\Signoffable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SignoffController extends Controller
{
    public function firstPost(string $object, string $id): RedirectResponse
    {
        $signoffable = $this->getModel($object, $id);
        if ($signoffable->doFirstSignoff()) {
            session()->flash('success', 'The item has been signed off.');
        } else {
            session()->flash('danger', 'There was a problem signing off the item.');
        }

        return redirect()->route('signoff.show', [$object, $id]);
    }

    public function secondPost(string $object, string $id): RedirectResponse
    {
        $signoffable = $this->getModel($object, $id);
        if ($signoffable->doSecondSignoff()) {
            session()->flash('success', 'The item has been fully signed off.');
        } else {
            session()->flash('danger', 'There was a problem fully signing off the item.');
        }

        return redirect()->route('signoff.show', [$object, $id]);
    }

    public function show(string $object, string $id): View
    {
        $args                = [];
        $args['object']      = $object;
        $args['id']          = $id;
        $args['signoffable'] = $this->getModel($object, $id);

        return view(config('signoff.views.show'), $args);
    }

    private function getModel(string $object, string $id): Signoffable
    {
        $modelName = str_replace(' ', '', ucwords(str_replace('-', ' ', $object)));

        // Convert the $object string to studly case, so 'care-plan' becomes 'CarePlan'
        $model = 'App\\Models\\' . $modelName;

        // Check if the class actually exists
        if (!class_exists($model)) {
            abort(404, 'The model type could not be found.');
        }

        if (!new $model() instanceof Signoffable) {
            throw new \Exception('The model "'.$modelName.'" must implement the Signoffable interface.');
        }

        // Find the model by its ID
        $signoffable = $model::find($id);

        // Check if the instance actually exists
        if ($signoffable) {
            return $signoffable;
        }

        abort(404, 'The model instance could not be found.');
    }
}
