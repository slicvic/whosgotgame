<?php

namespace App\Presenters;

use App\Models\EventStatus;

class EventPresenter extends BasePresenter
{
    /**
     * Present the title.
     *
     * @return string
     */
    public function title()
    {
        return ucwords(strtolower($this->model->title));
    }

    /**
     * Present the start date and time.
     *
     * @param string $format
     * @return string
     */
    public function when($format = 'short')
    {
        switch ($format) {
            case 'short':
                $format = 'm/d/Y g:i A';
                break;
            case 'medium':
            case 'long':
                $format = 'l, F j, Y g:i A';
                break;
        }

        return date($format, strtotime($this->model->start_at));
    }

    /**
     * Present the status as plain text or bootstrap tag.
     *
     * @param bool $asHtml
     * @return string
     */
    public function status($asHtml = false)
    {
        switch ($this->model->status->id) {
            case EventStatus::ACTIVE:
                if ($this->model->hasPassed()) {
                    return ($asHtml) ? '<span class="tag tag-warning">Passed</span>' : 'Passed';
                }
                return ($asHtml) ? '<span class="tag tag-success">On</span>' : 'On';
            default:
                return ($asHtml) ? '<span class="tag tag-danger">Canceled</span>' : 'Canceled';
        }
    }

    /**
     * Present the description.
     * 
     * @return string
     */
    public function description()
    {
        return str_replace("\n", '<br>', $this->model->description);
    }
}
