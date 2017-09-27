<?php

namespace Bahdcasts\Http\Requests;

use Bahdcasts\Series;

class CreateSeriesRequest extends SeriesRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image'
        ];
    }

    /**
     * Store series in request to the database
     * 
     * @return redirect()
     */
    public function storeSeries() 
    {
        $series = Series::create([
            'title' => $this->title,
            'slug' => str_slug($this->title),
            'description' => $this->description,
            'image_url' => 'series/' . $this->fileName
        ]);

        session()->flash('success', 'Series created successfully.');
        return redirect()->route('series.show', $series->slug);
    }
}
