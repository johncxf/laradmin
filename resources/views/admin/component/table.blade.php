<div class="col-sm-12">
    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
        <thead>
            {{$thead}}
        </thead>
        <tbody>
            {{$tbody}}
        </tbody>
        @if(isset($have_tfoot) and $have_tfoot === true)
            <tfoot>
                {{$tfoot}}
            </tfoot>
        @endif
    </table>
</div>