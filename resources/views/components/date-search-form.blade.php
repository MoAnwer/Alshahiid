<div class="search-form">
  <form action="{{ URL::current() }}" method="GET">
    
    <div class="row px-1 mt-4">

      {{ $inputs ?? '' }}

      <div class="col-1">
          <label>السنة: </label>
          <div class="form-group">
            <input type="number" class="py-4 form-control" max="2100" min="1900" step="1" name="year" value="{{ request('year') }}" />
          </div>
        </div>

      <div class="col-1">
          <label>الشهر: </label>
          <div class="form-group">
            <input type="number" class="py-4 form-control" min="1" max="12" step="1" name="month" value="{{ request('month') }}" />
          </div>
        </div>



      <div class="col-1 mt-3 d-flex align-items-center justify-content-center">
        <button class="btn py-4 btn-primary active form-control ml-1" title="بحث ">
          <i class="bi bi-search ml-2"></i>
        </button>
        <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() . '?show=false' }}">
          <i class="bi bi-menu-button ml-2"></i>
        </a>
      </div>

    </form>

    </div>
</div>
