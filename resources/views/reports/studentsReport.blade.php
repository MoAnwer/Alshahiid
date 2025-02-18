@include('components.header', ['page_title' => 'احصاء الطلاب'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>احصاء الطلاب</h4>
          <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
        </div>

        
      <hr>

       <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
              
              <div class="col-2">
                <label>النوع :</label>
                <div class="form-group">
                    <select name="gender" class="form-select">
                      <option value="all">ذكور و إناث</option>
                      <option value="ذكر" @selected(request('gender') == 'ذكر')>ذكور</option>
                      <option value="أنثى" @selected(request('gender') == 'أنثى')>إناث</option>
                    </select>
                  </div>
              </div>
              
              <div class="col-2">
                <label>المرحلة :</label>
                <div class="form-group">
                    <select name="stage" class="form-select">
                      <option value="all">كل المراحل</option>
                      <option value="الإبتدائي" @selected(request('stage') == 'الإبتدائي')>الإبتدائي</option>
                      <option value="المتوسط" @selected(request('stage') == 'المتوسط')>المتوسط</option>
                      <option value="الثانوي"  @selected(request('stage') == 'الثانوي')>الثانوي</option>
                      <option value="جامعي"  @selected(request('stage') == 'جامعي')>جامعي</option>
                      <option value="فوق الجامعي"  @selected(request('stage') == 'فوق الجامعي')>فوق الجامعي</option>
                    </select>
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

              <div class="col-1  d-flex align-items-center">
              <div class="mt-3 ml-1 d-flex align-items-center flex-column justify-content-center">
                <button class="btn py-4 btn-primary active form-control " title="بحث ">
                  <i class="bi bi-search ml-2"></i>
                </button>
              </div>

              <div class="mt-3 d-flex align-items-center flex-column justify-content-center">
              <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button ml-2"></i>
                </a>
              </div>

              </div>
              </form>

            </div>
        </div>

		  <x-table>
			  <x-slot:head>
			    <th>النوع</th>
			    <th>المرحلة</th>
			    <th>العدد</th>
          <th>النسبة</th>
        </x-slot:head>
			
			<x-slot:body>
        @php
          $totalCount =  @$maleCount + @$femaleCount;
          $totalPer = 0
        @endphp
          
          @if (request()->query('gender') == 'ذكر'  ||request()->query('gender') == 'all' || empty(request()->query('gender')))
          <tr>

              <td>ذكور</td>
              
              <td>

                @if (empty(request()->query('stage')))
                  كل المراحل
                @elseif (request()->query('stage') == 'all')
                  كل المراحل
                @else
                  {{  request()->query('stage') }}
                @endif

              </td>
              <td>{{ number_format( @$maleCount ?? '0') }}</td>
              <td>
                @if (@$maleCount> 0 || $totalCount > 0)
                  {{ round((@$maleCount / $totalCount) * 100, 2) . '%' }}
                  @php($totalPer += (@$maleCount / $totalCount) * 100)
                @else
                  0%
                @endif
              </td>

            </tr>

            @endif
  
            @if (request()->query('gender') == 'أنثى' ||request()->query('gender') == 'all' || empty(request()->query('gender')))
                      
              <tr>
                  <td>إناث</td>

                  <td>
                  @if (empty(request()->query('stage')))
                      كل المراحل
                    @elseif (request()->query('stage') == 'all')
                      كل المراحل
                    @else
                      {{  request()->query('stage') }}
                    @endif
                  </td>

                  <td>{{ number_format(@$femaleCount ?? '0') }}</td>
                  <td>
                    @if (@$femaleCount > 0 && $totalCount > 0)
                      {{ round((@$femaleCount  / $totalCount) * 100, 2) . '%' }}
                      @php($totalPer += (@$femaleCount  / $totalCount) * 100)
                    @else
                      0%
                    @endif
                  </td>
              </tr>

            @endif

          <tr class="border border-top">
              <td><b>المجموع<b></td>
              <td>-</td>
              <td><b>{{$totalCount}}</b></td>
              <td>

                <b>
                  {{ round($totalPer, 2) . '%' }}
                <b>

              </td>
          </tr>

            <caption class="text-primary">
              احصاء الطلاب
              @if(request()->query('sector') != 'all' && !is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' && !is_null(request()->query('locality'))) 
                كل المحليات
              @else
               محلية  {{ request()->query('locality')  }}
              @endif

               @empty(!request()->query('year'))
                {{ 'سنة ' . request()->query('year')  . (request()->query('month') != '' ?  ' شهر ' . request()->query('month') : ' لكل الشهور     ')}}
              @endempty
            </caption>
          
			</x-slot:body>

		  </x-table>

    </div>

  </div>

  @include('components.footer')