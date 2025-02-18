@include('components.header', ['page_title' => 'تقارير الخدمات الصحية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center mt-3 px-3">
          <h4>تقارير الخدمات العلاجية</h4>
          <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
        </div>

        <hr>

       {{-- search form --}}
        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
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

              <div class="col-3">
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

              <div class="col-2">
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
            </form>

          </div>
      </div>

        {{-- search form --}}


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
              <tr>
                <td>التأمين الصحي</td>
                <td>{{ $report->get('tamiin')['need'][0]->count ?? 0 }}</td>
                <td>{{ $report->get('tamiin')['done'][0]->count ?? 0 }}</td>
                <td>{{ round(((@$report->get('tamiin')['done'][0]->count ?? 0) / (@$report->get('tamiin')['need'][0]->count ?? 1)) * 100, 1) . '%'  }}</td>
                <td>{{ number_format((@$report->get('tamiin')['done'][0]->totalBudget ?? 0) + (@$report->get('tamiin')['need'][0]->totalBudget)) }}</td>
                <td>{{ number_format((@$report->get('tamiin')['need'][0]->budget_from_org ?? 0) +  (@$report->get('tamiin')['done'][0]->budget_from_org ?? 0)) }}</td>
                <td>{{ number_format((@$report->get('tamiin')['need'][0]->budget_out_of_org ?? 0) +  (@$report->get('tamiin')['done'][0]->budget_out_of_org ?? 0)) }}</td>
                <td>{{ 
                 number_format( (@$report->get('tamiin')['need'][0]->budget_out_of_org ?? 0) +  (@$report->get('tamiin')['done'][0]->budget_out_of_org ?? 0)
                    + (@$report->get('tamiin')['need'][0]->budget_from_org ?? 0) +  (@$report->get('tamiin')['done'][0]->budget_from_org ?? 0))
                }}</td>
              </tr>

              <tr>
                <td>علاج خارج المظلة</td>  
                <td>{{ @$report->get('teatmentsOutOfOrg')['need'][0]->count ?? 0 }}</td>
                <td>{{ @$report->get('teatmentsOutOfOrg')['done'][0]->count ?? 0 }}</td>
                <td>{{ round(((@$report->get('teatmentsOutOfOrg')['done'][0]->count ?? 0) / (@$report->get('teatmentsOutOfOrg')['need'][0]->count ?? 1)) * 100, 1) . '%' }}</td>
                <td>{{ number_format((@$report->get('teatmentsOutOfOrg')['need'][0]->totalBudget ?? 0) + (@$report->get('teatmentsOutOfOrg')['done'][0]->totalBudget ?? 0) ) }}</td>
                <td>{{ number_format((@$report->get('teatmentsOutOfOrg')['need'][0]->budget_from_org ?? 0) +  (@$report->get('teatmentsOutOfOrg')['done'][0]->budget_from_org ?? 0)) }}</td>
                <td>{{ number_format((@$report->get('teatmentsOutOfOrg')['need'][0]->budget_out_of_org ?? 0) +  (@$report->get('teatmentsOutOfOrg')['done'][0]->budget_out_of_org ?? 0)) }}</td>
                <td>{{ 
                   number_format( (@$report->get('teatmentsOutOfOrg')['need'][0]->budget_out_of_org ?? 0) +  (@$report->get('teatmentsOutOfOrg')['done'][0]->budget_out_of_org ?? 0)
                    + (@$report->get('teatmentsOutOfOrg')['need'][0]->budget_from_org ?? 0) +  (@$report->get('teatmentsOutOfOrg')['done'][0]->budget_from_org ?? 0))
                  }}</td>
              </tr>


              <tr>
                <td>العلاج بالخارج</td>  
                <td>{{ @$report->get('outTeatments')['need'][0]->count ?? 0 }}</td>
                <td>{{ @$report->get('outTeatments')['done'][0]->count ?? 0 }}</td>
                <td>{{ round(((@$report->get('outTeatments')['done'][0]->count ?? 0) / (@$report->get('outTeatments')['need'][0]->count ?? 1)) * 100, 1) . '%' }}</td>
                <td>{{ number_format((@$report->get('outTeatments')['need'][0]->totalBudget ?? 0) + (@$report->get('outTeatments')['done'][0]->totalBudget ?? 0)) }}</td>
                <td>{{ number_format((@$report->get('outTeatments')['need'][0]->budget_from_org ?? 0) +  (@$report->get('outTeatments')['done'][0]->budget_from_org ?? 0)) }}</td>
                <td>
                  {{ (@$report->get('outTeatments')['need'][0]->budget_out_of_org ?? 0) +  (@$report->get('outTeatments')['done'][0]->budget_out_of_org ?? 0) }}
                </td>
                <td>
                  {{ 
                    number_format((@$report->get('outTeatments')['need'][0]->budget_out_of_org ?? 0) +  (@$report->get('outTeatments')['done'][0]->budget_out_of_org ?? 0)
                    + (@$report->get('outTeatments')['need'][0]->budget_from_org ?? 0) +  (@$report->get('outTeatments')['done'][0]->budget_from_org ?? 0))
                  }}
                </td>


              </tr>
              <tr>
                <td>
                  <b>الاجمالي</b>
                </td>

                <td>
                  {{ 
                     (@$report->get('tamiin')['need'][0]->count ?? 0)
                     + (@$report->get('outTeatments')['need'][0]->count ?? 0)
                     + (@$report->get('teatmentsOutOfOrg')['need'][0]->count ?? 0)
                    }}
                </td>

                <td>
                  {{ 
                     (@$report->get('tamiin')['done'][0]->count ?? 0)
                     + (@$report->get('outTeatments')['done'][0]->count ?? 0)
                     + (@$report->get('teatmentsOutOfOrg')['done'][0]->count ?? 0)
                    }}
                </td>

                <td>
                  {{ 
                    round(((@(@$report->get('tamiin')['done'][0]->count ?? 0)
                                          + (@$report->get('outTeatments')['done'][0]->count ?? 0)
                                          + (@$report->get('teatmentsOutOfOrg')['done'][0]->count ?? 0)
                          ) / 
                                          (
                                            (@$report->get('tamiin')['need'][0]->count ?? 0)
                                            + (@$report->get('outTeatments')['need'][0]->count ?? 0)
                                            + (@$report->get('teatmentsOutOfOrg')['need'][0]->count ?? 1)
                                          )
                      ) * 100, 1) . '%'
                    }}
                </td>

                <td>
                  {{ 
                    number_format((@$report->get('tamiin')['need'][0]->totalBudget ?? 0) + (@$report->get('tamiin')['done'][0]->totalBudget ?? 0)
                    + (@$report->get('teatmentsOutOfOrg')['need'][0]->totalBudget ?? 0) + (@$report->get('teatmentsOutOfOrg')['done'][0]->totalBudget ?? 0)
                    + (@$report->get('outTeatments')['need'][0]->totalBudget ?? 0) + (@$report->get('outTeatments')['done'][0]->totalBudget ?? 0))
                  }}
                </td>


                <td>
                  {{ 
                   number_format( ($report->get('tamiin')['need'][0]->budget_from_org ?? 0) + ($report->get('tamiin')['done'][0]->budget_from_org ?? 0)
                    + ($report->get('teatmentsOutOfOrg')['need'][0]->budget_from_org ?? 0) + ($report->get('teatmentsOutOfOrg')['done'][0]->budget_from_org ?? 0)
                    + ($report->get('outTeatments')['need'][0]->budget_from_org ?? 0) + ($report->get('outTeatments')['done'][0]->budget_from_org ?? 0))
                  }}
                </td>


                <td>
                  {{ 
                    number_format(($report->get('tamiin')['need'][0]->budget_out_of_org ?? 0) + ($report->get('tamiin')['done'][0]->budget_out_of_org ?? 0)
                    + ($report->get('teatmentsOutOfOrg')['need'][0]->budget_out_of_org ?? 0) + ($report->get('teatmentsOutOfOrg')['done'][0]->budget_out_of_org ?? 0)
                    + ($report->get('outTeatments')['need'][0]->budget_out_of_org ?? 0) + ($report->get('outTeatments')['done'][0]->budget_out_of_org ?? 0))
                  }}
                </td>

                <td>
                    
                  {{ 

                    number_format(

                      ($report->get('tamiin')['need'][0]->budget_out_of_org ?? 0) +  ($report->get('tamiin')['done'][0]->budget_out_of_org ?? 0)
                      + ($report->get('tamiin')['need'][0]->budget_from_org ?? 0) +  ($report->get('tamiin')['done'][0]->budget_from_org ?? 0)

                      +
                      ($report->get('teatmentsOutOfOrg')['need'][0]->budget_out_of_org ?? 0) +  ($report->get('teatmentsOutOfOrg')['done'][0]->budget_out_of_org ?? 0)
                      + ($report->get('teatmentsOutOfOrg')['need'][0]->budget_from_org ?? 0) +  ($report->get('teatmentsOutOfOrg')['done'][0]->budget_from_org ?? 0)
                      +

                      ($report->get('outTeatments')['need'][0]->budget_out_of_org ?? 0) +  ($report->get('outTeatments')['done'][0]->budget_out_of_org ?? 0)
                      + ($report->get('outTeatments')['need'][0]->budget_from_org ?? 0) +  ($report->get('outTeatments')['done'][0]->budget_from_org ?? 0)

                    )

                  }}

                </td>

              </tr>
              
                <caption class="text-primary">
                  تقرير  الخدمات العلاجية
                   @if(request()->query('force') != 'all')
                    {{ request()->query('force') }}
                    @endif
    
                  @if(request()->query('sector') != 'all' || is_null(request()->query('sector')))
                    {{ request()->query('sector') }}
                  @else
                  كل القطاعات
                  @endif
    
                  @if( request()->query('locality') == 'all' || is_null(request()->query('locality'))) 
                    كل المحليات
                  @else
                  {{ '-' . request()->query('locality')  }}
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