<div class="form-group">
    <label for="employer-name">Employer (<span class="text-danger">&#42;</span>)</label>
    <input class="form-control" id="employer-name" type="text" placeholder="name" name="name"
        value="{{ $employer->name ?? old('name') }}" required>
</div>
<div class="form-group">
    <label for="employer-phone">Phone (<span class="text-danger">&#42;</span>)</label>
    <input class="form-control" id="phone" type="text" placeholder="phone" name="phone"
        value="{{ $employer->phone ?? old('phone') }}" required>
</div>
<div class="form-group">
    <label for="password">Password</label>
    <input class="form-control" id="password" type="password" placeholder="password" name="password">
</div>
<div class="form-group">
    <label for="employer-avatar">Avatar</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input preview-image" data-target="#employer-avatar" name="avatar"
            accept="image/*">
        <label class="custom-file-label" for="employer-avatar">Choose file</label>
    </div>
    <div class="mt-3">
        <img class="img-avatar rounded" id="employer-avatar" style="display: {{ isset($employer) ? '' : 'none' }}" src="{{ $employer->avatar_url ?? '' }}" width="400"
            height="350" />
    </div>
</div>
<div class="form-group">
    <label for="employer-thumbnail">Thumbnail</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input preview-image" data-target="#employer-thumbnail" name="thumbnail"
            accept="image/*">
        <label class="custom-file-label" for="employer-thumbnail">Choose file</label>
    </div>
    <div class="mt-3">
        <img class="img-avatar rounded" id="employer-thumbnail" style="display:{{ isset($employer) ? '' : 'none' }}" src="{{ $employer->thumbnail_url ?? '' }}" width="400"
            height="350" />
    </div>
</div>
<div class="form-group">
    <label>Province (<span class="text-danger">&#42;</span>)</label>
    <select name="province_id" class="form-control" id="province_dropdown" required>
        @foreach ($provinces as $item)
            <option value="{{ $item->id }}"
              {{ isset($employer) && $employer->province_id == $item->id ? 'selected' : '' }}
              >{{ $item->name }}
        </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="employer-address">Address (<span class="text-danger">&#42;</span>)</label>
    <input class="form-control" id="employer-address" type="text" placeholder="Địa chỉ" name="address"
        value="{{ $employer->address ?? old('address') }}" required>
</div>
<div class="form-group">
    <label for="employer-description">Description</label>
    <textarea id='employer-description' class="form-control" name="description"
        rows="3">{{ $employer->description ?? old('description') }}</textarea>
</div>
@push('script')
    <script>
        $('.preview-image').change(function(e) {
            if (e.currentTarget.files && e.currentTarget.files[0]) {
                const reader = new FileReader();
                const imageTarget = e.currentTarget.dataset.target;
                reader.onload = function(e) {
                    $(imageTarget)
                        .css('display', '')
                        .attr('src', e.target.result)
                        .width(400)
                        .height(350);
                }

                reader.readAsDataURL(e.currentTarget.files[0]);
            }
        });
    </script>
@endpush
