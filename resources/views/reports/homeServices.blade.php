@include('components.header', ['page_title' => 'تقارير السكن'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
        @php($totalDone = 0)
        @php($totalNeed = 0)

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تقارير خدمات السكن</h4>
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
              <label>نوع المشروع: </label>
                  <div class="form-group">
                  <select class="form-select" name="type">
                    <option value="all">الكل</option>
                    @foreach(['تشييد', 'اكمال التشييد'] as $type)
                      <option value="{{ $type }}" @selected(request('type') == $type)>{{ $type }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-2">
              <label>القوة: </label>
                  <div class="form-group">
                  <select class="form-select" name="force">
                    <option value="all">الكل</option>
                    @foreach(['جهاز الأمن','شرطة موحدة','قوات مسلحة','قرارات','شهداء الكرامة'] as $force)
                      <option value="{{ $force }}" @selected(request('force') == $force)>{{ $force }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-2">
                          
                  <label>الشريحة</label>
                  
                  <div class="form-group">
                    <select class="form-select" name="category">
                       <option value="all">الكل</option>
                      @foreach(['أرملة و ابناء','أب و أم و أخوان و أخوات','أخوات','مكتفية'] as $category)
                        <option value="{{ $category }}" @selected(request('category') == $category)>{{ $category }}</option>
                      @endforeach
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
                    <input type="number" class="py-4 form-control" max="2100" min="1900" step="1" name="year" placeholder="{{ request('year') }}" />
                  </div>
                </div>

              <div class="col-1">
                  <label>الشهر: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" min="1" max="12" step="1" name="month" placeholder="{{ request('month') }}" />
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



        <x-table>
           <x-slot:head>
              <th>نوع الخدمة</th>
              <th>مطلوب</th>
              <th>منفذ</th>
              <th>النسبة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة</th>
              <th>الاجمالي الكلي</th>
            </x-slot:head>
      
           <x-slot:body>
           
            @if(is_null(request()->query('type')) || (request()->query('type') == 'all' || request()->query('type') == 'تشييد' ))
              <tr>
                <td>تشييد</td>

                  <td>{{ @$homeServicesReport->get('تشييد')['مطلوب'][0]->count ?? 0 }}</td>
                  <td>{{ @$homeServicesReport->get('تشييد')['منفذ'][0]->count ?? 0 }}</td>
                  <td>
                    @if (@$homeServicesReport->get('تشييد')['منفذ'][0]->count > 0 && @$homeServicesReport->get('تشييد')['مطلوب'][0]->count > 0)
                      {{ round((@$homeServicesReport->get('تشييد')['منفذ'][0]->count / @$homeServicesReport->get('تشييد')['مطلوب'][0]->count) * 100, 2).'%' }}
                    @else
                      0%
                    @endif
                  </td>

                  <td>{{ number_format((@$homeServicesReport->get('تشييد')['مطلوب'][0]->totalBudget ?? 0) +  (@$homeServicesReport->get('تشييد')['منفذ'][0]->totalBudget ?? 0)) }}</td>

                  <td>{{ number_format((@$homeServicesReport->get('تشييد')['مطلوب'][0]->budget_from_org ?? 0 ) +  (@$homeServicesReport->get('تشييد')['منفذ'][0]->budget_from_org ?? 0)) }}</td>

                  <td>{{ number_format((@$homeServicesReport->get('تشييد')['مطلوب'][0]->budget_out_of_org ?? 0) +  (@$homeServicesReport->get('تشييد')['منفذ'][0]->budget_out_of_org ?? 0)) }}</td>

                  <td>
                    {{  
                      number_format(
                            ((@$homeServicesReport->get('تشييد')['مطلوب'][0]->totalMoney ?? 0)  +  (@$homeServicesReport->get('تشييد')['منفذ'][0]->totalMoney ?? 0))
                        )
                    }}
                  </td>
              </tr>
            @endif
            
            @if(is_null(request()->query('type')) || (request()->query('type') == 'all' || request()->query('type') == 'اكمال التشييد'  ))

            <tr>
              <td>اكمال التشييد</td>

                <td>{{ @$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->count ?? 0 }}</td>
                <td>{{ @$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->count ?? 0 }}</td>
                <td>
                  @if (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->count > 0 && @$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->count > 0)
                    {{ round((@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->count / @$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->count) * 100, 2).'%' }}
                  @else
                    0%
                  @endif
                </td>

                <td>{{ number_format((@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->totalBudget ?? 0) +  (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->totalBudget ?? 0)) }}</td>

                <td>{{ number_format((@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->budget_from_org ?? 0 ) +  (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->budget_from_org ?? 0)) }}</td>

                <td>{{ number_format((@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->budget_out_of_org ?? 0) +  (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->budget_out_of_org ?? 0)) }}</td>

                <td>
                  {{  
                    number_format(
                          ((@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->totalMoney ?? 0)  +  (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->totalMoney ?? 0))
                      )
                   }}
                </td>

            </tr>

            @endif
            
            <tr>
              <td>الاجمالي</td>
              <td>{{ (@$homeServicesReport->get('تشييد')['مطلوب'][0]->count ?? 0) + (@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->count ?? 0)  }}</td>
              <td>{{ (@$homeServicesReport->get('تشييد')['منفذ'][0]->count ?? 0) + (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->count ?? 0)  }}</td>
              @php($totalNeed = ((@$homeServicesReport->get('تشييد')['مطلوب'][0]->count ?? 0) + (@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->count ?? 0)))
              @php($totalDone = ((@$homeServicesReport->get('تشييد')['منفذ'][0]->count ?? 0) + (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->count ?? 0)))
              <td>
                  {{ $totalDone > 0 && $totalNeed > 0 ? round(($totalDone / $totalNeed) * 100, 2) .'%' : '0%'}}
              </td>
              
              <td>
                  {{ 
                    number_format(
                          ((@$homeServicesReport->get('تشييد')['مطلوب'][0]->totalBudget ?? 0) + (@$homeServicesReport->get('تشييد')['منفذ'][0]->totalBudget ?? 0)) + ((@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->totalBudget ?? 0)  +  (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->totalBudget ?? 0))

                    )  
                  }}
              </td>

              <td>
                  {{ 
                    number_format(
                          ((@$homeServicesReport->get('تشييد')['مطلوب'][0]->budget_from_org ?? 0) + (@$homeServicesReport->get('تشييد')['منفذ'][0]->budget_from_org ?? 0)) + ((@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->budget_from_org ?? 0)  +  (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->budget_from_org ?? 0))

                    )  
                  }}
              </td>

              <td>
                  {{ 
                    number_format(
                          ((@$homeServicesReport->get('تشييد')['مطلوب'][0]->budget_out_of_org ?? 0) + (@$homeServicesReport->get('تشييد')['منفذ'][0]->budget_out_of_org ?? 0)) + ((@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->budget_out_of_org ?? 0)  +  (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->budget_out_of_org ?? 0))

                    )  
                  }}
              </td>
              
              <td>
                  {{ 
                    number_format(
                          ((@$homeServicesReport->get('تشييد')['مطلوب'][0]->totalMoney ?? 0) + (@$homeServicesReport->get('تشييد')['منفذ'][0]->totalMoney ?? 0)) + ((@$homeServicesReport->get('اكمال التشييد')['مطلوب'][0]->totalMoney ?? 0)  +  (@$homeServicesReport->get('اكمال التشييد')['منفذ'][0]->totalMoney ?? 0))

                    )  
                  }}
              </td>
            </tr>
            <caption class="text-primary">
              مشاريع سكن  
              
              @if(request()->query('type') != 'all')
                {{ request()->query('type') }}
              @endif


              @if(request()->query('force') != 'all')
                {{ request()->query('force') }}
              @endif

              @if(request()->query('category') != 'all')
                {{ request()->query('category') }}
              @endif

              @if(request()->query('sector') != 'all' && !is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' && !is_null(request()->query('locality'))) 
                كل المحليات
              @else
              {{ request()->query('locality')  }}
              @endif

               @empty(!request()->query('year'))
                {{ 'سنة ' . request()->query('year')  . (request()->query('month') != '' ?  ' شهر ' . request()->query('month') : ' لكل الشهور     ')}}
              @endempty
            </caption>

           </x-slot:body>


         </x-table>
      </div>

      

      </div>
    </div>

  @include('components.footer')