
            @foreach ($rating as $item)
            <div class="my-3 ">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class=" rounded-circle bg-secondary text-white reviewName" >
                            <h4 class="text-center">{{ substr($item->name, 0, 1) }}</h4>
                        </div>
                        <div class="">
                            <small class="ms-3 mt-1 d-block">{{$item->name}}</small>
                            <small class="ms-3">
                                @for ($i = 0 ; $i< $item->rating; $i++)
                            <i class="fas fa-star star-light mr-1 main_star text-white"></i>
                            @endfor
                            </small>
                        </div>
                    </div>

                    <div class="text-end">
                        {{ $item->created_at->diffForHumans() }}
                    </div>
                </div>
                <div style="text-indent: 50px" class="mt-3">
                    {{$item->review}}
                </div>


                <hr>
            </div>
        @endforeach
            {{$rating->links()}}
