<ul class="list-group mb-3 mt-3">
    @foreach($document_folders as $key => $document)
    <li class="list-group-item">
        <div class="row align-items-center gx-2">
            <div class="col-auto">
            <i class="tio-folder tio-xl text-body mr-2"></i>
            </div>
            <div class="col">
            <a href="javascript:;" data-toggle="collapse" data-target="#collapse-{{$document->unique_id}}" data-folder="{{$document->unique_id}}" aria-expanded="true" aria-controls="collapse-{{$document->unique_id}}" onclick="fetchDocuments('{{$record->unique_id}}','{{$document->unique_id}}')" class="text-dark">
            <h5 class="card-title text-truncate mr-2">
                {{$document->name}}
            </h5>
            <ul class="list-inline list-separator small">
                {{--<li class="list-inline-item">{{count($document->Files)}} Files</li>--}}
            </ul>
            </a>
            </div>
            <span class="card-btn-toggle">
            <span class="card-btn-toggle-default">
                <i class="tio-add"></i>
            </span>
            <span class="card-btn-toggle-active">
                <i class="tio-remove"></i>
            </span>
            </span>
        </div>
        <div id="collapse-{{$document->unique_id}}" class="collapse" aria-labelledby="headingOne">
        </div>
        <!-- End Row -->
    </li>
    @endforeach
</ul>