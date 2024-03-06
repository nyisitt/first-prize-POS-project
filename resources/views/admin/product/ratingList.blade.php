@extends('admin.master')
@section('content')
    <div class="row">
        <div class="offset-2 col-8  mt-5">
            <button class="text-white btn btn-secondary" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></button>
            <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top">
                <caption style="color:white; font-size:25px">Rating and Review show Table</caption>
                <thead class="table-dark">
                  <tr>
                    <th >No</th>
                    <th >Name </th>
                    <th>Email</th>
                    <th >Rating</th>
                    <th >Reviews</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($ratingList as $key=>$rating)
                    <tr>
                        <td>{{ $key +1 }}</td>
                        <td>{{$rating->name}}</td>
                        <td>{{$rating->email}}</td>
                        <td>
                            @for ($i=0 ; $i< $rating->rating ; $i++)
                            <i class="fa-solid fa-star"></i>
                            @endfor
                        </td>
                        <td class="text-start">{{$rating->review}}</td>
                        <td>{{$rating->created_at->format('M,j,Y')}}</td>
                    </tr>
                   @endforeach


                </tbody>
              </table>
        </div>
    </div>
@endsection
