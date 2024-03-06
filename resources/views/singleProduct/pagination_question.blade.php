
   @foreach ($comment as $item)

   <div class="my-2">
    <div class="d-flex ">
       <div class="ms-3"><i class="fa-solid fa-question"></i></div>
       <div class="ms-3">
           <h6 class="mb-0 pb-0">{{$item->comment}}</h6>
           <p class="text-muted" > <span style="font-size: 15px">{{$item->email}}</span >  - <span style="font-size: 15px">{{$item->created_at->diffForHumans()}}</span> </p>
       </div>
   </div>

    <div class="">
           @if ($item->reply !== null)
           <div class="d-flex ">
               <div class="ms-3"><i class="fa-solid fa-message"></i></div>
               <div class="ms-3">
                   <h6 class="mb-0 pb-0">{{$item->reply}}</h6>
                   <p class="text-muted" > <span style="font-size: 15px">Answered from Admin</span >  - <span style="font-size: 15px">{{$item->updated_at->diffForHumans()}}</span> </p>
               </div>
           </div>
           @else
               <div class="text-muted ms-3">No answer yet</div>
           @endif
    </div>
   </div>
   <hr>

   @endforeach

