<div>
    <svg data-unique-id="{{$uniqueId}}" class="h-5 w-5 text-gray-500 cursor-pointer btn-image-upload"
         xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
              d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
              clip-rule="evenodd"/>
    </svg>
    <div class="hidden">
        <input type="file" data-post-url="{{route('upload.image')}}" name="image-file-{{$uniqueId}}"
               data-unique-id="{{$uniqueId}}"
               data-question-id="{{$questionId}}"
               onchange="imageUpload(this)">
    </div>
</div>
<div id="images-box-{{$uniqueId}}" data-unique-id="{{$uniqueId}}" data-question-id="{{$questionId}}"
     class="mt-3 flex items-center question-qa-images-{{$question['id']}}">
    @foreach($images as $imageItem)
        <img src="{{$imageItem}}" class="rounded shadow mr-3 mb-3 image-upload-item" width="120" height="120">
    @endforeach
</div>
<div class="w-full flex items-center text-gray-400 text-xs">
    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
              clip-rule="evenodd"/>
    </svg>
    <span>点击图片可删除</span>
</div>