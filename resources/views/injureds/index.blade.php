@include('components.header', ['page_title' => 'قائمة مصابي العمليات'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>قائمة مصابي العمليات</h4>
          <div class="d-flex justify-content-between align-items-center ">

		        <a class="btn btn-primary active" href="{{ route('injureds.create') }}">إضافة مصاب جديد</a>
                       
            {{-- Show btns --}}
              @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
                <a class="btn btn-info active  mr-2" href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
                  <i class="bi bi-eye-slash ml-2"></i>
                  إخفاء ازرار العمليات
                </a>
              @else
                <a class=" mr-2 btn btn-success active " href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }}" >
                  <i class="bi bi-eye ml-2"></i>
                    عرض ازرار العمليات
                </a>
              @endif
            {{--/ Show btns --}}
             <button class="mx-4 btn btn-primary active" onclick="printContainer()">
                <i class="bi bi-printer ml-2"></i>
                طباعة 
              </button>
          </div>

         

        </div>
      <hr>


      <x-alert/>


      <div class="search-form px-4">
        <form action="{{ URL::current() }}" method="GET">
        <div class="row px-1 mt-4"> 
          <div class="col-2">
            <label>بحث باستخدام:</label>
            <div class="form-group">
                <select name="search" class="form-select">
                  <option value="all" @selected(request('search') == 'all')> ---- </option>
                  <option value="name"  @selected(request('search') == 'name')>اسم</option>
                  <option value="health_insurance_number" @selected(request('search') == 'health_insurance_number')>رقم التأمين الصحي</option>
                  <option value="phone"  @selected(request('search') == 'phone')>رقم الهاتف</option>
                  <option value="national_number"  @selected(request('search') == 'national_number')>الرقم الوطني</option>
                </select>
              </div>
          </div>

          <div class="col-4">
            <label>بحث عن : </label>
            <div class="form-group">
              <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
            </div>
          </div>

          <div class="col-2">
            <label>القطاع :</label>
            <div class="form-group">
                <select name="sector" class="form-select">
                  <option value="all">كل القطاعات</option>
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
                  <option value="all">كل المحليات </option>
                  @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                    <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                    @endforeach
                  </select>
              </div>
          </div>

        <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
          <button class="btn py-4 btn-primary active form-control " title="بحث ">
            <i class="bi bi-search ml-2"></i>
          </button>
        </div>


        <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
          <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() }}">
            <i class="bi bi-menu-button ml-2"></i>
          </a>
        </div>

        
        </div>
        
      </from>
      
    </div>

    <div id="printArea">
		    <hr />
        <x-table>
          <x-slot:head>
            <th>اسم</th>
            <th>رقم الهاتف</th>
            <th>الرقم الوطني</th>
            <th>نوع الاصابة</th>
            <th>نسبة الاصابة</th>
            <th>رقم تأمين صحي</th>
            <th>بداية تأمين صحي</th>
            <th>نهاية تأمين صحي</th>
            <th>تاريخ الاصابة</th>
             
             @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
              <th>القطاع</th>
            @endif
            
            @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
              <th>المحلية</th>
            @endif

            @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
              <th>عمليات</th>
            @endif

          </x-slot:head>

        <x-slot:body>
		  @if($injureds->count() > 0)
			@foreach($injureds as $injured)
      <tr>
				<td>{{ $injured->name }}</td>
				<td>{{ $injured->phone ?? '-' }}</td>
				<td>{{ $injured->national_number ?? '-' }}</td>
				<td>{{ $injured->type ?? '-' }}</td>
				<td>{{ round($injured->injured_percentage, 1) . '%' }}</td>
        <td>{{ $injured->health_insurance_number }}</td>
        <td>{{ $injured->health_insurance_start_date }}</td>
        <td>{{ $injured->health_insurance_end_date }}</td>
				<td>{{ $injured->injured_date  ?? '-' }}</td>
         
        @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
  				<td>{{ $injured->sector }}</td> 
        @endif
        @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
        <td>{{ $injured->locality }}</td>
        @endif
        
        @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
        <td>
            <a href="{{ route('injureds.edit', $injured->id) }}" class="btn btn-success py-1 px-2">
              <i class="bi bi-pen" title="تعديل"></i>
            </a>
            <a href="{{ route('injureds.delete', $injured->id) }}" class="btn btn-danger py-1 px-2">
              <i class="bi bi-trash-fill" title="حذف"></i>
            </a>
            <a href="{{ route('injureds.show', $injured->id) }}" class="btn btn-primary active  py-1 px-2">
              <i class="bi bi-person-fill" title="عرض ملف المصاب"></i>
            </a>
        </td>
        @endif

      </tr>

      @endforeach
      
        @else
          <tr>
            <td colspan="10">لا توجد نتائج</td>
          </tr>
        @endif

        <caption>
          قائمة مصابي العمليات
          
              @if(request()->query('sector') != 'all')
                @if (request()->query('locality') == 'all')
                  كل القطاعات
                @else
                   {{ request()->query('sector') }}  
                @endif
              @endif

              @if( request()->query('locality') == 'all') 
                كل المحليات
              @else
              {{ '-' . request()->query('locality')  }}
              @endif
        </caption>
          </x-slot:body>
        </x-table>

        {{ $injureds->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}

      </div>
        </div>
      </div>
    </div>

  @include('components.footer')