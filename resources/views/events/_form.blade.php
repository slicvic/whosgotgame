<form action="{{ ($event->exists) ? route('events.update', ['id' => $event->id]) : route('events.store') }}" method="post" id="events--create-edit-form" class="js-validate-form">
    <div v-html="errors"></div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Title</label>
        <div class="col-sm-10">
            <input
                type="text"
                name="event[title]"
                class="form-control"
                placeholder="e.g. Soccer Sundays"
                value="{{ $event->present()->title() }}"
                data-parsley-required-message="Give it a title e.g. Soccer Sundays"
                required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Sport</label>
        <div class="col-sm-10">
            <select
                name="event[type_id]"
                class="form-control"
                data-parsley-required-message="What's it about?"
                required>
                <option value="">Pick a Sport</option>
                @foreach (\App\Models\EventType::all() as $type)
                    <option value="{{ $type->id }}"{{ ($event->type_id == $type->id) ? ' selected' : '' }}>{{ $type->label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Where</label>
        <div class="col-sm-10">
            <input type="hidden" name="venue[latlng][lat]" id="venue-lat" value="{{ ($event->exists) ? $event->venue->latlng[0] : '' }}">
            <input type="hidden" name="venue[latlng][lng]" id="venue-lng" value="{{ ($event->exists) ? $event->venue->latlng[1] : '' }}">
            <input type="hidden" name="venue[address]" id="venue-address" value="{{ ($event->exists) ? $event->venue->address : '' }}">
            <input type="hidden" name="venue[url]" id="venue-url" value="{{ $event->exists ? $event->venue->url : '' }}">
            <input
                type="text"
                name="venue[name]"
                class="form-control js-typeahead-venue"
                value="{{ ($event->exists) ? $event->venue->name : '' }}"
                required
                placeholder="e.g. Wilde Park"
                data-parsley-required-message="Where's it at?"
                data-bind-field-lat="#venue-lat"
                data-bind-field-lng="#venue-lng"
                data-bind-field-address="#venue-address"
                data-bind-field-url="#venue-url">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">When</label>
        <div class="col-sm-10">
            <input
                type="text"
                name="event[start_at]"
                placeholder="e.g. 10/08/2016 1:00 PM"
                class="form-control js-datetimepicker"
                value="{{ ($event->exists) ? $event->present()->when() : '' }}"
                data-parsley-required-message="What date and time?"
                required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Duration</label>
        <div class="col-sm-10">
            <select name="event[duration]" class="form-control">
                <?php $duration = $event->calculateDuration() ?>
                @for ($i=1; $i <= 10; $i++)
                    <option value="{{ $i }}"{{ ($i == $duration ) ? ' selected' : '' }}>{{ $i }} {{ ($i == 1) ? 'hour' : 'hours' }}</option>
                @endfor
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
            <select name="event[status_id]" class="form-control">
                @foreach (\App\Models\EventStatus::all() as $status)
                    <option value="{{ $status->id }}"{{ ($event->status_id == $status->id) ? ' selected' : '' }}>{{ $status->label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
            <textarea name="event[description]" class="form-control" rows="8" cols="40">{{ $event->description }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <a href="{{ route('account.events.index') }}" class="btn btn-default">Cancel</a>
            <button
                type="submit"
                class="btn btn-primary btn-lg"
                v-bind:disabled="submitted"
                v-html="submitButtonText">Save</button>
        </div>
    </div>
</form>
