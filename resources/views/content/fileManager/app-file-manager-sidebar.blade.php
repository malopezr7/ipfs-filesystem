@section('content-sidebar')
<div class="sidebar-file-manager">
  <div class="sidebar-inner">
    <!-- sidebar menu links starts -->
    <!-- add file button -->
    <div class="dropdown dropdown-actions">
      <button
        class="btn btn-primary add-file-btn text-center btn-block"
        type="button"
        id="addNewFile"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="true"
      >
        <span class="align-middle">Add New</span>
      </button>
      <div class="dropdown-menu" aria-labelledby="addNewFile">
        <div class="dropdown-item" data-toggle="modal" data-target="#new-folder-modal">
          <div class="mb-0">
            <i data-feather="folder" class="mr-25"></i>
            <span class="align-middle">Folder</span>
          </div>
        </div>
        <div class="dropdown-item">
          <div class="mb-0 input-file">
            <i data-feather="upload-cloud" class="mr-25"></i>
            <span class="align-middle">File Upload</span>
          </div>
        </div>
        <div class="dropdown-item">
          <div class="mb-0 input-folder">
            <i data-feather="upload-cloud" class="mr-25"></i>
            <span class="align-middle">Folder Upload</span>
          </div>
        </div>
      </div>
    </div>
    <!-- add file button ends -->

    <!-- sidebar list items starts  -->
    <div class="sidebar-list">
      <!-- links for file manager sidebar -->
      <div class="list-group">
        <div class="my-drive"></div>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
          <i data-feather="hard-drive" class="mr-50 font-medium-3"></i>
          <span class="align-middle">My drive</span>
        </a>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action">
          <i data-feather="share-2" class="mr-50 font-medium-3"></i>
          <span class="align-middle">Shared With Me</span>
        </a>
      </div>
      <!-- storage status of file manager ends-->
    </div>
    <!-- side bar list items ends  -->
    <!-- <div class="sidebar-menu-list">
    </div> -->
    <!-- sidebar menu links ends -->
  </div>
</div>
@endsection
