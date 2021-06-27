class FileUploaderV2{
  constructor(el, api, id, parent, readonly = false){
    this.el = el;
    this.parent = parent;
    this.id = id;
    this.renderFileUploader();
    this.findComponent();
    this.registerHandler();
    this.api = api;
    this.deleteHandler = (_, __) => null;
    this.swalDeleteConfigure = {
      title: "Konfirmasi hapus",
      text: "Yakin akan menghapus data ini?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya, Hapus!",
    }
    this.base_url = window.location.href.replace(new RegExp('index.php.*'), '');
    this.readonly = readonly;
  }  

  updateAttachment(files, readonly = false){
    this.files = files;
    this.readonly = readonly;
    this.renderAttachment(this);
  }

  renderFileUploader(){
    this.el.html(`
      <a href="#" class="btn btn-success btn-xs" id="add_attachment"><strong><i class="fas fa-paperclip"></i> Tambah Attachment</strong></a>
      <input type="file" id="file_attachment" name="file_attachment" style="display:none" accept="image/*">
      <div id="attachment" style="display:flex; margin-top:8px; margin-bottom:-20px"></div>
    `);
  }

  findComponent(){
    this.file_attachment = this.el.find('#file_attachment'),
    this.add_attachment = this.el.find('#add_attachment'),
    this.attachment = this.el.find('#attachment'),
    this.files = {}
  }

  registerHandler(){
    var ctx = this;

    this.add_attachment.on('click', function(e){
      ctx.file_attachment.click();
    });
    
    this.file_attachment.on('change', function(){
      if(this.files.length >= 1){
        ctx.uploadAttachment();
      }
    });
  }

  uploadAttachment(){
    var ctx = this;

    event.preventDefault();
    swal({title: 'Upload file...', allowOutsideClick: false});
    swal.showLoading();
    $.ajax({
      url: `${ctx.api['add']}`, 'type': 'POST',
      data: new FormData(ctx.parent.form[0]), contentType: false, processData: false,
      success: function (data){
        swal.close();
        ctx.file_attachment.val(null);
        var json = JSON.parse(data);
        if(json['error']){
          swal("Simpan Gagal", json['message'], "error");
          return;
        }
        var attachment = json['data']
        ctx.files[attachment[ctx.id]] = attachment;
        swal("Upload Berhasil", "", "success");
        ctx.renderAttachment(ctx);
      },
      error: function(e) {}
    });
  }

  renderAttachment(ctx = this){
    ctx.add_attachment.toggle(!ctx.readonly);
    var data = ctx.files;
    if(data == null || typeof data != "object") return;

    ctx.attachment.empty();
    ctx.attachment.toggle(Object.keys(data).length != 0);
    Object.values(data).forEach((a) => {
      var attachment = `
        <input name="attachment[]" value=${a[ctx.id]} style="display:none"/>
        <div class="file-box file">
            <span class="corner"></span>
            <a target="_blank" href="${ctx.base_url}${a['url']}">
              <div class="image"><img alt="image" class="img-fluid" src="${ctx.base_url}${a['url']}"></div>
            </a>
            <div class="file-name">
              <div style="display:flex">
                <span style="overflow: hidden;height: 3em;line-height: 1.5em;flex: 1;word-wrap: break-word;">${a['filename']}</span>
                ${ctx.readonly ? '' : `<span class="delete btn btn-danger btn-circle btn-xs btn-outline" style="float:right" data-id="${a[ctx.id]}">X</span>`}
              </div>
              <small>Size: ${a['size']} KB</small>
            </div>
          </a>
        </div>
      `;
      ctx.attachment.append(attachment);
    });
    ctx.attachment.find('.delete').on('click', (e) => { ctx.deleteAttachment($(e.target).data('id')) });
  }

  registerDeleteHandler(deleteHandler){
    this.deleteHandler = deleteHandler;
  }

  deleteAttachment(id){
    var ctx = this;
    
    swal(ctx.swalDeleteConfigure).then((result) => {
      if(!result.value){ return; }
      swal({title: 'Deleting file...', allowOutsideClick: false});
      swal.showLoading();
      var data = {};
      data[ctx.id] = id;
      $.ajax({
        url: `${ctx.api['delete']}`, 'type': 'POST',
        data: data,
        success: function (data){
          swal.close();
          var json = JSON.parse(data);
          if(json['error']){
            swal("Simpan Gagal", json['message'], "error");
            return;
          }
          delete ctx.files[id];
          ctx.deleteHandler(ctx, id);
          swal("Delete Berhasil", "", "success");
          ctx.renderAttachment(ctx);
        },
        error: function(e) {}
      });
    });
  }

}