<div class="row">

    @foreach ($products as $product)
        @if ($product->is_featured)
            <a href="{{ $product->href }}">
                <div class="col-lg-4 mb-4">
                    <img class="img-thumbnail img-fluid" alt="" src="{{ $product->hero_image_url }}" />
                </div>
            </a>
        @endif
    @endforeach

</div>
