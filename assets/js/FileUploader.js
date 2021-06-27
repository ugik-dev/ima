class FileUploader{
  constructor(el, currentFile, filename, accept, showLabel = true, required = false){
    this.currentFile = currentFile;
    this.el = el;
    this.filename = filename;
    this.accept = accept;
    this.defaultFileName = null;
    this.showLabel = showLabel;
    this.required = required;
    this.render();
    this.init();
    this.assignControl();
  }  

  render(){
    var label = this.showLabel ? `<label for="${this.filename}Filename">Dokumen ${capFirstLetter(this.filename.replace(/_/g, ' '))}</label>` : '';
    this.el.html(`
      <div class="form-group">
        ${label}
        <div class="input-group">
          <input type="text" class="form-control" id="${this.filename}Filename" name="${this.filename}Filename" onfocus="blur();" placeholder="Tidak ada" style="background-color:#e9ecef">
          <div class="input-group-append">
            <button class="btn btn-outline-success file-upload-btn" type="button" id="downloadFileButton" style="display:none" data-toggle="tooltip" data-placement="top" title="Unduh File"><i class="fa fa-download"></i></button>
            <button class="btn btn-outline-primary file-upload-btn" type="button" id="browseFileButton" data-toggle="tooltip" data-placement="top" title="Pilih File"><i class="fa fa-folder-open"></i></button>
            <button class="btn btn-outline-danger file-upload-btn" type="button" id="deleteFileButton" style="display:none" data-toggle="tooltip" data-placement="top" title="Hapus File"><i class="fa fa-trash"></i></button>
            <button class="btn btn-outline-warning file-upload-btn" type="button" id="cancelFileButton" style="display:none" data-toggle="tooltip" data-placement="top" title="Batal"><i class="fa fa-ban"></i></button>
          </div>
        </div>
        <input type="file" id="file" name="${this.filename}" style="display:none" accept="${this.accept}">
        <input type="text" id="delete_file" name="delete_${this.filename}" style="display:none">
      </div>
    `);
    this.el.find('[data-toggle="tooltip"]').tooltip();
  }

  init(){
    this.file = this.el.find('#file');
    this.fileFilename = this.el.find(`#${this.filename}Filename`);
    this.fileFilename.attr('required', this.required);
    this.downloadFileButton = this.el.find('#downloadFileButton');
    this.browseFileButton = this.el.find('#browseFileButton');
    this.deleteFileButton = this.el.find('#deleteFileButton');
    this.cancelFileButton = this.el.find('#cancelFileButton');
    this.deleteFile = this.el.find('#delete_file');
    this.resetState();
  }

  assignControl(){
    var context = this;
    
    this.downloadFileButton.on('click', function(){
      var base_url = window.location.href.replace(new RegExp('index.php.*'), '');
      window.open(`${base_url}uploads/${context.filename}/` + context.fileFilename.val() + '?ver=' + Date.now());
    });

    this.browseFileButton.on('click', function(){
      context.file.click();
    });

    this.file.on('change', function(){
      if(this.files.length >= 1){
        context.fileFilename.val(this.files[0].name);
        context.cancelFileButton.show();
        context.deleteFileButton.hide();
        context.downloadFileButton.hide();
      } else {
        context.cancelFileButton.trigger("click");
      }
    });

    this.deleteFileButton.on('click', function(){
      context.cancelFileButton.show();
      context.fileFilename.val("File akan di delete");
      context.deleteFile.val(context.currentFile);
      context.deleteFileButton.hide();
      context.browseFileButton.hide();
      context.downloadFileButton.hide();
      context.file.val(null);
    });

    this.cancelFileButton.on('click', function(){
      context.cancelFileButton.hide();
      context.file.val(null);
      if(context.currentFile != null && context.currentFile != ""){
        context.fileFilename.val(context.currentFile);
        context.deleteFile.val(null);
        context.deleteFileButton.show();
        context.browseFileButton.show();
        context.downloadFileButton.show();
      } else {
        context.fileFilename.val(context.defaultFileName);
      }
    });
  }

  resetState(){
    this.fileFilename.val(this.defaultFileName);
    this.deleteFileButton.hide();
    this.cancelFileButton.hide();
    this.downloadFileButton.hide();
    this.browseFileButton.show();
    this.deleteFile.val(null);
    this.file.val(null);
  }

  updateCurrentFile(currentFile){
    this.currentFile = currentFile;
    if(this.currentFile == null || this.currentFile == ""){
      this.resetState();
      return;
    }
    this.fileFilename.val(this.currentFile);
    this.browseFileButton.show();
    this.deleteFileButton.show();
    this.downloadFileButton.show();
  }

  isNoFile(){
    return this.fileFilename.val() == this.defaultFileName; 
  }

  setEditable(editable = true){
    if(editable == true){
      this.browseFileButton.removeClass("notEditableHide")
      this.deleteFileButton.removeClass("notEditableHide")
    } else {
      this.browseFileButton.addClass("notEditableHide")
      this.deleteFileButton.addClass("notEditableHide")
    }
  }

  setRequired(required = true){
    this.required = required;
    this.fileFilename.attr('required', this.required);
  }

  getContainer(){
    return this.el;
  }

}