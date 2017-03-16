@extends('layouts.app')

@section('content')

@endsection

@push('styles')
@endpush

@push('scripts')
    <script type="text/javascript" src="/js/jquery-scanner-detection/jquery.scannerdetection.js"></script>
    <script type="text/javascript">
        $(document).scannerDetection({
            timeBeforeScanTest: 200, // wait for the next character for upto 200ms
            startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
            endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
            avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
            onComplete: function(barcode, qty){
                alert(barcode);
            } // main callback function
        });
    </script>
@endpush