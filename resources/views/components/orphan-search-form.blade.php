
          <div class="search-form mx-3 mt-3">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-2">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="">بحث باستخدام </option>
                      <option value="name" @selected(request('search') == 'name')>اسم </option>
                      <option value="age" @selected(request('search') == 'age')>العمر</option>
                      <option value="national_number" @selected(request('search') == 'national_number')>الرقم الوطني</option>
                      <option value="martyr_name"  @selected(request('search') == 'martyr_name')>اسم الشهيد</option>
                      <option value="force" @selected(request('search') == 'force')>القوة العسكرية للشهيد</option>
                    </select>
                </div>
              </div>

            <div class="col-1">
                <label>حالة الخدمة :</label>
                <div class="form-group">
                    <select name="status" class="form-select">
                      <option value="all">الكل</option>
                      <option value="مطلوب" @selected(request('status') == 'مطلوب')>مطلوب</option>
                      <option value="منفذ" @selected(request('status') == 'منفذ')>منفذ</option>
                    </select>
                </div>
            </div>

              <div class="col-2">
                <label>القيمة: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

              
              <div class="col-2">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
                      <option value="all"  @selected(request('sector') == "all")>كل القطاعات</option>
                      <option value="القطاع الشرقي"  @selected(request('sector') == 'القطاع الشرقي')>القطاع الشرقي</option>
                      <option value="القطاع الشمالي" @selected(request('sector') == 'القطاع الشمالي')>القطاع الشمالي</option>
                      <option value="القطاع الغربي"  @selected(request('sector') == 'القطاع الغربي')>القطاع الغربي</option>
                    </select>
                  </div>
              </div>

              <div class="col-2">
                  <label>المحلية: </label>
                  <div class="form-group">
                    <select name="locality" class="form-select">
                      <option value="all"  @selected(request('sector') == "all")>كل المحليات</option>
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-1">
                  <label>السنة: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" max="2100" min="1900" step="1" name="year" value="{{ request('year') ?? 'all' }}" placeholder="{{ request('year') }}" />
                  </div>
                </div>

              <div class="col-1">
                  <label>الشهر: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" min="1" max="12" step="1" name="month" value="{{ request('month') ?? 'all' }}" placeholder="{{ request('month')  }}" />
                  </div>
                </div>

              <div class="col-1 mt-3 d-flex align-items-center">
                <button class="btn py-3 px-2 btn-primary active form-control ml-2" title="بحث">
                  <i class="bi bi-search"></i>
                </button>
                <a class="btn py-3 px-2 btn-success active form-control " title="القائمة" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button"></i>
                </a>
              </div>
              


              </form>

            </div>
        </div>