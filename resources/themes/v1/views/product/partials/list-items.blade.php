@if (!empty($products) && $products->count())
    <div class="row products">
        @include('product.partials.items')
    </div>
    <div class="text-center">
{{--        {!! $products->render() !!}--}}
{{--        {{ $products->links() }}--}}
        @if($products->hasMorePages())
            <a href="{{$products->nextPageUrl()}}" class="btn-see-more text-uper">see more</a>
        @endif
    </div>
@else
    <div class="row products">
        No products
    </div>
@endif

@push('scripts')
    <script type="text/javascript" src="/themes/v1/js/jquery.lazyload.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("img.lazy").lazyload({
                effect : "fadeIn"
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.btn-see-more', function (e) {
                var url = $(this).attr('href');
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (data) {
                        if(data) {
                            $('.products').append(data.html);
                            if(data.next_page){
                                $('.btn-see-more').attr('href', data.next_page)
                            }else{
                                $('.btn-see-more').remove();
                            }
                            $("img.lazy").lazyload({
                                effect : "fadeIn"
                            });
                        }
                    }
                });
                return false;
            });
        });
    </script>
@endpush