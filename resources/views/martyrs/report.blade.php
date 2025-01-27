@include('components.header', ['page_title' => 'احصاء الشهداء'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>احصاء الشهداء</h4>
        </div>
        <x-table>
          <x-slot:head>
            <th>القوة</th>
            <th>قوات مسلحة</th>
            <th>شرطة موحدة</th>
            <th>جهاز الأمن</th>
            <th>قرارات</th>
            <th>شهداء الكرامة</th>
            <th>الاجمالي</th>
          </x-slot:head>
			
			    <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ $report->get('قوات مسلحة')[0]->count ?? 0 }}</td>
              <td>{{ $report->get('شرطة موحدة')[0]->count ?? 0 }}</td>
              <td>{{ $report->get('جهاز الأمن')[0]->count ?? 0 }}</td>
              <td>{{ $report->get('قرارات')[0]->count ?? 0 }}</td>
              <td>{{ $report->get('شهداء الكرامة')[0]->count ?? 0 }}</td>
              <td>{{ $totalCount }}</td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                {{ isset($report->get('قوات مسلحة')[0]->count) ? round(($report->get('قوات مسلحة')[0]->count / $totalCount) * 100, 1) . '%' : 0}}
              </td>
              <td>
                {{ isset($report->get('شرطة موحدة')[0]->count) ? round(($report->get('شرطة موحدة')[0]->count / $totalCount) * 100, 1).'%' : 0}} 
              </td>
              <td>
                {{ isset($report->get('جهاز الأمن')[0]->count) ? round(($report->get('جهاز الأمن')[0]->count / $totalCount) * 100, 1).'%' : 0}} 
              </td>
              <td>
                {{ isset($report->get('قرارات')[0]->count) ? round(($report->get('قرارات')[0]->count / $totalCount) * 100, 1).'%' : 0}} 
              </td>
              <td>
                {{ isset($report->get('شهداء الكرامة')[0]->count) ?  round(($report->get('شهداء الكرامة')[0]->count / $totalCount) * 100, 1).'%':0 }} 
              </td>
              <td>{{ $totalCount.'%'}}</td>
            </tr>
			    </x-slot:body>

		    </x-table>

      </div>
    </div>

  @include('components.footer')