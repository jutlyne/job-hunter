<div class="modal" id="myModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Category</label>
                        <input required type="text" id="newCategory" name="newCategory" placeholder="Vui lòng nhập category" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary error" id="btnAddCategory" onclick="smFrmCategory()" disabled>Save</button>
            </div>

        </div>
    </div>
</div>