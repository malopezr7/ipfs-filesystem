<input type="hidden" id="parent_id" value="{{ !is_null($parent) ? $parent->id : '' }}">
<div class="row breadcrumbs-top">
    <div class="col-12">
        <h2 class="content-header-title float-left mb-0">{{ !is_null($parent) ? $parent->element->name : 'Home' }}</h2>
        <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
                {{-- this will load breadcrumbs dynamically from controller --}}
                <li class="breadcrumb-item">
                    <a href="javascrip:void(0)" onclick="loadTree()">
                        <i class="mr-1" data-feather="home"></i>
                    </a>
                </li>
                @if(!is_null($parent))
                    @if(!is_null($bread_crumb))
                        @foreach($bread_crumb as $element)
                            <li class="breadcrumb-item">
                                    <a href="javascript:void(0)" onclick="loadTree({{$element['id']}})">
                                        {{ $element['name'] }}
                                    </a>
                            </li>
                        @endforeach
                    @endif

                    <li class="breadcrumb-item active">
                        <span aria-current="location">{{ $parent->element->name }}</span>
                    </li>
                @endif
            </ol>
        </div>
    </div>
</div>

<div class="view-container" style="margin-top: 1%">
    <div class="files-header">
        <h6 class="font-weight-bold mb-0">Filename</h6>
        <div>
            <h6 class="font-weight-bold file-item-size d-inline-block mb-0">Size</h6>
            <h6 class="font-weight-bold file-last-modified d-inline-block mb-0">Last modified</h6>
            <h6 class="font-weight-bold d-inline-block mr-1 mb-0">Actions</h6>
        </div>
    </div>
    <div class="card file-manager-item folder level-up">
        <div class="card-img-top file-logo-wrapper">
            <div class="d-flex align-items-center justify-content-center w-100">
                <i data-feather="arrow-up"></i>
            </div>
        </div>
        <div class="card-body pl-2 pt-0 pb-1">
            <div class="content-wrapper">
                <p class="card-text file-name mb-0">...</p>
            </div>
        </div>
    </div>
    @foreach($tree as $element)
        @switch($element->element_type)
            @case('App\StorageFolder')
            <div class="card file-manager-item folder" data-item-id="{{ $element->id }}">
                <div class="card-img-top file-logo-wrapper">
                    <div class="dropdown float-right">
                        <i data-feather="more-vertical" class="toggle-dropdown mt-n25"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-center w-100">
                        <i data-feather="folder"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="content-wrapper">
                        <p class="card-text file-name mb-0">{{ $element->element->name }}</p>
                        <p class="card-text file-size mb-0">{{ $element->children->count() }} elements</p>
                        <p class="card-text file-date">01 may 2019</p>
                    </div>
                    <small class="file-accessed text-muted">Last update: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($element->updated_at))->diffForHumans() }}</small>
                </div>
            </div>
            @break
            @case('App\StorageFile')
            <div class="card file-manager-item file" data-item-id="{{ $element->id }}">
                <div class="card-img-top file-logo-wrapper">
                    <div class="dropdown float-right">
                        <i data-feather="more-vertical" class="toggle-dropdown mt-n25"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-center w-100">
                        <img src="{{ asset('images/icons/'. explode('/', $element->element->content_type)[1] .'.png') }}" alt="file-icon"
                             height="35"/>
                    </div>
                </div>
                <div class="card-body">
                    <div class="content-wrapper">
                        <a href="{{ route('files.get-file',['id'=>$element->id]) }}" class="card-text file-name mb-0">
                            {{ $element->element->name }}
                        </a>
                    </div>
                    <small class="file-accessed text-muted">Last update: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($element->updated_at))->diffForHumans() }}</small>
                </div>
            </div>
            @break
        @endswitch
    @endforeach
    <div class="d-none flex-grow-1 align-items-center no-result mb-3">
        <i data-feather="alert-circle" class="mr-50"></i>
        No Results
    </div>
</div>