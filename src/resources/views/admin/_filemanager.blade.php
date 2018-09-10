<filepicker class="filepicker @foreach($options as $option) {{ 'filepicker-'.$option }} @endforeach" id="filepicker" url-base="{{ route('api::index-files') }}">

</filepicker>
