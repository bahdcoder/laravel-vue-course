<?php

namespace Bahdcasts\Http\Requests;

class UpdateSeriesRequest extends SeriesRequest
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
            'description' => 'required'
        ];
    }

    /**
     * Update a series into database
     *
     * @param [Bahdcasts\Series] $series
     * @return void
     */
    public function updateSeries($series) {
        if($this->hasFile('image')) {
            $series->image_url = 'series/' . $this->uploadSeriesImage()->fileName;
        }
        $series->title = $this->title;
        $series->description = $this->description;
        $series->slug = str_slug($this->title);

        $series->save();
    }
}
