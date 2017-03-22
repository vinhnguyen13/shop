@extends('layouts.app')

@section('content')
    <?php
    $url = 'https://www.instagram.com/glab.vn/media/';
    $content = file_get_contents($url);
    $obj = \GuzzleHttp\json_decode($content);
    if(!empty($obj->items)){
        foreach($obj->items as $item){
            $html = '<a href="https://www.instagram.com/glab.vn/" target="_blank">'.Html::image($item->images->low_resolution->url).'</a>';
            echo $html;
        }
    }
    ?>
@endsection

@push('styles')
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){

    });
</script>
@endpush