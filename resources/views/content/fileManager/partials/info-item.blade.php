<div class="modal-header d-flex align-items-center justify-content-between mb-1 p-2">
    <h5 class="modal-title">{{ $element->element->name }}</h5>
    <div>
        <i data-feather="trash" class="cursor-pointer mr-50 delete" data-dismiss="modal"></i>
        <i data-feather="x" class="cursor-pointer" data-dismiss="modal"></i>
    </div>
</div>
<div class="modal-body flex-grow-1 pb-sm-0 pb-1">
    <ul class="nav nav-tabs tabs-line" role="tablist">
        <li class="nav-item">
            <a
                    class="nav-link active"
                    data-toggle="tab"
                    href="#details-tab"
                    role="tab"
                    aria-controls="details-tab"
                    aria-selected="true"
            >
                <i data-feather="file"></i>
                <span class="align-middle ml-25">Details</span>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="details-tab" role="tabpanel"
             aria-labelledby="details-tab">
            <div class="d-flex flex-column justify-content-center align-items-center py-5">
                <img src="{{ asset('images/icons/'.$element->type.'.png') }}" alt="file-icon" height="64"/>
                <p class="mb-0 mt-1">{{ Helper::formatBytes($element->size) }}</p>
            </div>
            <h6 class="file-manager-title my-2">Info</h6>
            <ul class="list-unstyled">
                <li class="d-flex justify-content-between align-items-center">
                    <p>Type</p>
                    <p class="font-weight-bold">{{ $element->type }}</p>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <p>Size</p>
                    <p class="font-weight-bold">{{ Helper::formatBytes($element->size) }}</p>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <p>Location</p>
                    <p class="font-weight-bold">{{ $element->full_url() }}</p>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <p>Owner</p>
                    <p class="font-weight-bold">{{ $element->element->user->name }}</p>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <p>Modified</p>
                    <p class="font-weight-bold">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($element->updated_at))->diffForHumans() }}</p>
                </li>

                <li class="d-flex justify-content-between align-items-center">
                    <p>Created</p>
                    <p class="font-weight-bold">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($element->created_at))->diffForHumans() }}</p>
                </li>
            </ul>
        </div>
    </div>
</div>