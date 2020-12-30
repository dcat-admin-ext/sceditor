<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <textarea class="form-control {{$class}}" name="{{$name}}" placeholder="{{ $placeholder }}" {!! $attributes !!} >{{ $value }}</textarea>

        @include('admin::form.help-block')

    </div>
</div>

<script require="@sceditor" init="{!! $selector !!}">
    sceditor.command.set('image', {
        exec: function(caller) {
            var editor = this,
                content =
                    '<div id="uploader-demo"><div id="fileList" class="uploader-list"></div><div id="filePicker">{upload}</div></div>' +
                    '<div class="section"><label for="url">{url}</label> ' +
                    '<input type="url" id="url" placeholder="http://" /><br/>' +
                    '<button id="insert" class="btn btn-primary">{insert}</button></div>';
            $.each({
                url: editor._('Image File URL'),
                upload: editor._("Upload"),
                insert: editor._('Insert')
            }, function (name, val) {
                content = content.replace(
                    new RegExp('\\{' + name + '\\}', 'g'), val
                );
            });
            content = $(content);
            content.find('#insert').click(function (e) {
                var val = content.find('#url').val();
                if (val) {
                    editor.wysiwygEditorInsertHtml(
                        '<img' + ' src="' + val + '" />'
                    );
                }
                editor.closeDropDown(true);
                e.preventDefault();
            });

            // 初始化Web Uploader
            var uploader = WebUploader.create({

                // 选完文件后，是否自动上传。
                auto: true,

                // swf文件路径
                swf: 'http://aitest.test/vendor/dcat-admin/dcat/plugins/webuploader/Uploader.swf',

                // 文件接收服务端。
                server: 'http://webuploader.duapp.com/server/fileupload.php',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });

            // 当有文件添加进来的时候
            uploader.on( 'fileQueued', function( file ) {
                var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '<div class="info">' + file.name + '</div>' +
                    '</div>'
                    ),
                    $img = $li.find('img');


                // $list为容器jQuery实例
                $list.append( $li );

                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr( 'src', src );
                }, thumbnailWidth, thumbnailHeight );
            });

            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id ),
                    $percent = $li.find('.progress span');

                // 避免重复创建
                if ( !$percent.length ) {
                    $percent = $('<p class="progress"><span></span></p>')
                        .appendTo( $li )
                        .find('span');
                }

                $percent.css( 'width', percentage * 100 + '%' );
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( file ) {
                $( '#'+file.id ).addClass('upload-state-done');
            });

            // 文件上传失败，显示上传出错。
            uploader.on( 'uploadError', function( file ) {
                var $li = $( '#'+file.id ),
                    $error = $li.find('div.error');

                // 避免重复创建
                if ( !$error.length ) {
                    $error = $('<div class="error"></div>').appendTo( $li );
                }

                $error.text('上传失败');
            });

            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).find('.progress').remove();
            });

            // var data = {};
            // data[uploadtoken] = 1;
            // content.find('#upload').uploadifive({
            //     fileObjName: "jform[img]",
            //     buttonClass: "uploadbtn",
            //     buttonText: editor._("Upload Image"),
            //     fileType: "image/jpeg,image/png,image/gif,image/bmp",
            //     multi: false,
            //     removeCompleted: true,
            //     formData: data,
            //     width: 160,
            //     uploadScript: upurl,
            //     onUploadComplete: function (file, data) {
            //         data = $.parseJSON(data);
            //         if (data.hasOwnProperty("errorcode")) {
            //         } else {
            //             editor.wysiwygEditorInsertHtml(
            //                 '<img' + ' src="' + data.url + '" />'
            //             );
            //         }
            //     }
            // });
            editor.createDropDown(caller, 'insertimage', content);

            // this is set to the editor instance
            this.insert('a1');
        },
        txtExec: function() {
            // this is set to the editor instance
            this.insert('a2');
        },
        tooltip: 'Insert the letter a'
    });

    var opts = {!! admin_javascript_json($options) !!};
    var textarea = document.getElementById(id);
    sceditor.create(textarea, opts);


</script>
