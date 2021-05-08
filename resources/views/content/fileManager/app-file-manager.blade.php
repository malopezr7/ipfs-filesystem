@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','File Manager')
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/vendors/css/extensions/jstree.min.css')}}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/pages/app-file-manager.css')) }}">
    <link rel="stylesheet" href="{{asset('css/base/plugins/extensions/ext-component-toastr.css')}}">
    <style>
        .content-left {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <!-- overlay container -->
    <div class="body-content-overlay"></div>

    <input type="file" id="file-upload" hidden/>

    <!-- file manager app content starts -->
    <div class="file-manager-main-content">
        <!-- search area start -->
        <div class="file-manager-content-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="btn-group">
                    <!-- add file button -->
                    <div class="dropdown dropdown-actions">
                        <button
                                class="btn btn-outline-primary p-50 btn-sm"
                                type="button"
                                id="addNewFile"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="true">
                            <i data-feather="plus"></i>
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
                        </div>
                    </div>
                    <!-- add file button ends -->
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="sidebar-toggle d-block d-xl-none float-left align-middle ml-1">
                    <i data-feather="menu" class="font-medium-5"></i>
                </div>
                <div class="input-group input-group-merge shadow-none m-0 flex-grow-1">
                    <div class="input-group-prepend">
          <span class="input-group-text border-0">
            <i data-feather="search"></i>
          </span>
                    </div>
                    <input type="text" class="form-control files-filter border-0 bg-transparent" placeholder="Search"/>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="file-actions">
                    <i data-feather="arrow-down-circle"
                       class="font-medium-2 cursor-pointer d-sm-inline-block d-none mr-50"></i>
                    <i data-feather="trash" class="font-medium-2 cursor-pointer d-sm-inline-block d-none mr-50"></i>
                    <i
                            data-feather="alert-circle"
                            class="font-medium-2 cursor-pointer d-sm-inline-block d-none"
                            data-toggle="modal"
                            data-target="#app-file-manager-info-sidebar"
                    ></i>
                    <div class="dropdown d-inline-block">
                        <i
                                class="font-medium-2 cursor-pointer"
                                data-feather="more-vertical"
                                role="button"
                                id="fileActions"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                        >
                        </i>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="fileActions">
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i data-feather="move" class="cursor-pointer mr-50"></i>
                                <span class="align-middle">Open with</span>
                            </a>
                            <a
                                    class="dropdown-item d-sm-none d-block"
                                    href="javascript:void(0);"
                                    data-toggle="modal"
                                    data-target="#app-file-manager-info-sidebar"
                            >
                                <i data-feather="alert-circle" class="cursor-pointer mr-50"></i>
                                <span class="align-middle">More Options</span>
                            </a>
                            <a class="dropdown-item d-sm-none d-block" href="javascript:void(0);">
                                <i data-feather="trash" class="cursor-pointer mr-50"></i>
                                <span class="align-middle">Delete</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i data-feather="plus" class="cursor-pointer mr-50"></i>
                                <span class="align-middle">Add shortcut</span>
                            </a>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i data-feather="folder-plus" class="cursor-pointer mr-50"></i>
                                <span class="align-middle">Move to</span>
                            </a>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i data-feather="star" class="cursor-pointer mr-50"></i>
                                <span class="align-middle">Add to starred</span>
                            </a>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i data-feather="droplet" class="cursor-pointer mr-50"></i>
                                <span class="align-middle">Change color</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i data-feather="download" class="cursor-pointer mr-50"></i>
                                <span class="align-middle">Download</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="btn-group btn-group-toggle view-toggle ml-50" data-toggle="buttons">
                    <label class="btn btn-outline-primary p-50 btn-sm active">
                        <input type="radio" name="view-btn-radio" data-view="grid" checked/>
                        <i data-feather="grid"></i>
                    </label>
                    <label class="btn btn-outline-primary p-50 btn-sm">
                        <input type="radio" name="view-btn-radio" data-view="list"/>
                        <i data-feather="list"></i>
                    </label>
                </div>
            </div>
        </div>
        <!-- search area ends here -->

        <div class="file-manager-content-body">
        </div>
    </div>
    <!-- file manager app content ends -->

    <!-- File Info Sidebar Starts-->
    <div class="modal modal-slide-in fade show" id="app-file-manager-info-sidebar">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
            </div>
        </div>
    </div>
    <!-- File Info Sidebar Ends -->

    <!-- File Dropdown Starts-->
    <div class="dropdown-menu dropdown-menu-right file-dropdown">
        <a class="dropdown-item info" href="javascript:void(0);">
            <i data-feather="info" class="align-middle mr-50"></i>
            <span class="align-middle">Info</span>
        </a>
        <a class="dropdown-item share" href="javascript:void(0);">
            <i data-feather="user-plus" class="align-middle mr-50"></i>
            <span class="align-middle">Share</span>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item delete" href="javascript:void(0);">
            <i data-feather="trash" class="align-middle mr-50"></i>
            <span class="align-middle">Delete</span>
        </a>
    </div>
    <!-- /File Dropdown Ends -->

    <!-- Create New Folder Modal Starts-->
    <div class="modal fade" id="new-folder-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="folder-name" class="form-control" placeholder="Untitled folder"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mr-1 store-folder">Create</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Create New Folder Modal Ends -->
    <!-- Create New Folder Modal Starts-->
    <div class="modal fade" id="share-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <input type="text" class="form-control" id="copy-to-clipboard-input"/>
                            </div>
                        </div>
                        <div class="col-sm-2 col-12">
                            <button class="btn btn-outline-primary" id="btn-copy">Copy!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Create New Folder Modal Ends -->
@endsection
@section('vendor-script')
    <script src="{{asset('vendors/js/extensions/jstree.min.js')}}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <!-- Page js files -->
    <script>
        var $html = $('html');

        $(document).ready(function () {
            loadTree();
        });

        function initComponents() {
            var sidebarFileManager = $('.sidebar-file-manager'),
                sidebarToggler = $('.sidebar-toggle'),
                fileManagerOverlay = $('.body-content-overlay'),
                filesTreeView = $('.my-drive'),
                sidebarRight = $('.right-sidebar'),
                filesWrapper = $('.file-manager-main-content'),
                viewContainer = $('.view-container'),
                fileManagerItem = $('.file-manager-item'),
                noResult = $('.no-result'),
                fileActions = $('.file-actions'),
                viewToggle = $('.view-toggle'),
                filterInput = $('.files-filter'),
                toggleDropdown = $('.toggle-dropdown'),
                sidebarMenuList = $('.sidebar-list'),
                fileDropdown = $('.file-dropdown'),
                fileContentBody = $('.file-manager-content-body');

            // Select File
            if (fileManagerItem.length) {
                fileManagerItem.find('.custom-control-input').on('change', function () {
                    var $this = $(this);
                    if ($this.is(':checked')) {
                        $this.closest('.file, .folder').addClass('selected');
                    } else {
                        $this.closest('.file, .folder').removeClass('selected');
                    }
                    if (fileManagerItem.find('.custom-control-input:checked').length) {
                        fileActions.addClass('show');
                    } else {
                        fileActions.removeClass('show');
                    }
                });
            }

            // Toggle View
            if (viewToggle.length) {
                viewToggle.find('input').on('change', function () {
                    var input = $(this);
                    viewContainer.each(function () {
                        if (!$(this).hasClass('view-container-static')) {
                            if (input.is(':checked') && input.data('view') === 'list') {
                                $(this).addClass('list-view');
                            } else {
                                $(this).removeClass('list-view');
                            }
                        }
                    });
                });
            }

            // Filter
            if (filterInput.length) {
                filterInput.on('keyup', function () {
                    var value = $(this).val().toLowerCase();

                    fileManagerItem.filter(function () {
                        var $this = $(this);

                        if (value.length) {
                            $this.closest('.file, .folder').toggle(-1 < $this.text().toLowerCase().indexOf(value));
                            $.each(viewContainer, function () {
                                var $this = $(this);
                                if ($this.find('.file:visible, .folder:visible').length === 0) {
                                    $this.find('.no-result').removeClass('d-none').addClass('d-flex');
                                } else {
                                    $this.find('.no-result').addClass('d-none').removeClass('d-flex');
                                }
                            });
                        } else {
                            $this.closest('.file, .folder').show();
                            noResult.addClass('d-none').removeClass('d-flex');
                        }
                    });
                });
            }

            // sidebar file manager list scrollbar
            if ($(sidebarMenuList).length > 0) {
                var sidebarLeftList = new PerfectScrollbar(sidebarMenuList[0], {
                    suppressScrollX: true
                });
            }

            if ($(fileContentBody).length > 0) {
                var rightContentWrapper = new PerfectScrollbar(fileContentBody[0], {
                    cancelable: true,
                    wheelPropagation: false
                });
            }

            // Files Treeview
            if (filesTreeView.length) {
                filesTreeView.jstree({
                    core: {
                        themes: {
                            dots: false
                        },
                        data: [
                            {
                                text: 'My Drive',
                                children: [
                                    {
                                        text: 'photos',
                                        children: [
                                            {
                                                text: 'image-1.jpg',
                                                type: 'jpg'
                                            },
                                            {
                                                text: 'image-2.jpg',
                                                type: 'jpg'
                                            }
                                        ]
                                    }
                                ]
                            }
                        ]
                    },
                    plugins: ['types'],
                    types: {
                        default: {
                            icon: 'far fa-folder font-medium-1'
                        },
                        jpg: {
                            icon: 'far fa-file-image text-info font-medium-1'
                        }
                    }
                });
            }

            // click event for show sidebar
            sidebarToggler.on('click', function () {
                sidebarFileManager.toggleClass('show');
                fileManagerOverlay.toggleClass('show');
            });

            // remove sidebar
            $('.body-content-overlay, .sidebar-close-icon').on('click', function () {
                sidebarFileManager.removeClass('show');
                fileManagerOverlay.removeClass('show');
                sidebarRight.removeClass('show');
            });

            // on screen Resize remove .show from overlay and sidebar
            $(window).on('resize', function () {
                if ($(window).width() > 768) {
                    if (fileManagerOverlay.hasClass('show')) {
                        sidebarFileManager.removeClass('show');
                        fileManagerOverlay.removeClass('show');
                        sidebarRight.removeClass('show');
                    }
                }
            });

            // making active to list item in links on click
            sidebarMenuList.find('.list-group a').on('click', function () {
                if (sidebarMenuList.find('.list-group a').hasClass('active')) {
                    sidebarMenuList.find('.list-group a').removeClass('active');
                }
                $(this).addClass('active');
            });

            // Toggle Dropdown
            if (toggleDropdown.length) {
                $('.file-logo-wrapper .dropdown').on('click', function (e) {
                    var $this = $(this);
                    let id = $(this).parent().parent().data('item-id');
                    console.log(id);
                    e.preventDefault();
                    if (fileDropdown.length) {
                        $('.view-container').find('.file-dropdown').remove();
                        if ($this.closest('.dropdown').find('.dropdown-menu').length === 0) {
                            fileDropdown
                                .clone()
                                .appendTo($this.closest('.dropdown'))
                                .addClass('show')
                                .attr('id', id)
                                .find('.dropdown-item')
                                .on('click', function () {
                                    $(this).closest('.dropdown-menu').remove();
                                });
                        }
                    }
                });
                $(document).on('click', function (e) {
                    if (!$(e.target).hasClass('toggle-dropdown')) {
                        filesWrapper.find('.file-dropdown').remove();
                    }
                });

                if (viewContainer.length) {
                    $('.file, .folder').on('mouseleave', function () {
                        $(this).find('.file-dropdown').remove();
                    });
                }
            }
        }

        $(document).on('click', '.folder .card-body', function () {
            let id = $(this).parent().data('item-id');
            loadTree(id);
        })

        $(document).on('click', '.share', function () {
            let id = $(this).parent().attr('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('get-share-link') }}',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (data) {
                    if (!data.success)
                        showMessage(data)
                    else {
                        $('#copy-to-clipboard-input').val(data.link);
                        $('#share-modal').modal('toggle');
                    }
                }
            })
        });

        $(document).on('click', '.info', function () {
            let id = $(this).parent().attr('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('get-info') }}',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (data) {
                    if (!data.success)
                        showMessage(data)
                    else {
                        $('#app-file-manager-info-sidebar .modal-content').html(data.content);
                        $('#app-file-manager-info-sidebar').modal('toggle');
                        feather.replace();
                    }
                }
            })
        });


        $(document).on('click', '.delete', function () {
            let id = $(this).parent().attr('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('delete') }}',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (data) {
                    showMessage(data);
                    loadTree();
                }
            })
        });

        $(document).on('click', '.store-folder', function () {
            let name = $('#folder-name').val();
            let parent = $('#parent_id').val();
            $.ajax({
                url: '{{ route('folders.store-folder') }}',
                data: {
                    id_parent: parent,
                    name: name
                },
                success: function (data) {
                    showMessage(data);
                    loadTree(parent);
                    $('#new-folder-modal').modal('toggle');
                },
                error: function (data) {
                    showMessage(data);
                }
            })
        });


        var userText = $('#copy-to-clipboard-input');
        $(document).on('click', '#btn-copy', function () {
            userText.select();
            document.execCommand('copy');
            toastr['success']('', 'Copied to clipboard!');
        })

        $(document).on('click', '.input-file', function () {
            $('#file-upload').trigger('click');
        });

        $(document).on('click', '.input-folder', function () {
            $('#folder-upload').trigger('click');
        });

        $(document).on('change', '#file-upload', function () {
            let parent = $('#parent_id').val();
            let files = $(this)[0].files;
            let fd = new FormData();
            fd.append('id_parent', parent);
            fd.append('file', files[0]);
            $.ajax({
                url: '{{ route('files.store-file') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                cache: false,
                data: fd,
                success: function (data) {
                    showMessage(data);
                    loadTree(parent);
                    // toastr.success('Imagen guardada correctamente');
                    // $('.new-cad-img').data('archivo_id', data.id);
                    // $('.new-cad-img').removeClass('new-cad-img');
                },
                error: function (data) {
                    showMessage(data);
                }
            })
        });


        function showMessage(data) {
            toastr[data.success ? 'success' : 'error']('👋 ' + data.message + '!.', (data.success ? 'Correcto' : 'Error') + '!', {
                closeButton: true,
                tapToDismiss: false,
                progressBar: true,
            });
        }


        function loadTree(parent = null) {
            $.ajax({
                url: '{{route('get-tree')}}',
                type: 'GET',
                data: {
                    parent: parent
                },
                beforeSend: function () {
                    reloadCard(true, '.file-manager-content-body');
                },
                success: function (data) {
                    $('.file-manager-content-body').html(data);
                    initComponents();
                    reloadCard(false, '.file-manager-content-body');
                    feather.replace();
                }
            })
        }

        function reloadCard(bol, element) {
            var block_ele = $(element);
            var reloadActionOverlay;
            if ($html.hasClass('dark-layout')) {
                reloadActionOverlay = '#10163a';
            } else {
                reloadActionOverlay = '#fff';
            }
            // Block Element
            if (bol) {
                block_ele.block({
                    message: feather.icons['refresh-cw'].toSvg({class: 'font-medium-1 spinner text-primary'}),
                    overlayCSS: {
                        backgroundColor: reloadActionOverlay,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        backgroundColor: 'none'
                    }
                });
            } else {
                block_ele.unblock();
            }
        }
    </script>
@endsection
