@if(count($discussions) > 0)
@foreach($discussions as $discussion)
<a class="card card-frame mb-3 mb-lg-5 text-dark" href="{{ url('topic/'.$discussion->slug) }}">
<div class="card-body">
  <!-- Icon Block -->
  <div class="media d-block d-sm-flex">
    <figure class="w-100 max-w-8rem mb-2 mb-sm-0 mr-sm-4">
      <img class="img-fluid" src="{{ userProfile($discussion->created_by,'m') }}" alt="SVG">
    </figure>
    <div class="media-body">
      <h2 class="h3">{{$discussion->group_title}}</h2>
      <p class="font-size-1 text-body text-dark">
        <?php echo substr($discussion->description,0,100)  ?>...
      </p>
      <div class="media">
       
        <div class="media-body">
          <!-- Article Authors -->
          <!-- <small class="d-block text-dark">1 article in this collection</small> -->
          <small class="d-block text-dark">
            <span class="text-muted">Added by</span>
            {{$discussion->User->first_name." ".$discussion->User->last_name}}
          </small>
          <!-- End Article Authors -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Icon Block -->
</div>
</a>
@endforeach
@else
<div class="text-danger text-center">No topic found</div>
@endif