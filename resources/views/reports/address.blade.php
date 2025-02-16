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
            <h4>تقارير السكن</h4>
          </div>

        {{--  --}}
        <x-search-form />
        {{--  --}}

		  <x-table>
			  <x-slot:head>
  			  <th>نوع الملكية</th>
          <th>ملك</th>
          <th>مؤجر</th>
          <th>حكومي</th>
          <th>ورثة</th>
          <th>استضافة</th>
          <th>قروي</th>
          <th>رحل </th>
          <th>أخرى</th>
          <th>المجموع</th>
        </x-slot:head>
			
			<x-slot:body>
        @php($totalCount = 0)
				<tr>
					<td>العدد</td>
          @if(!is_null($report->get('ملك')))
            <td title="{{ $report->get('ملك')[0]->type }}">{{ $report->get('ملك')[0]->count }}</td>
            @php($totalCount += $report->get('ملك')[0]->count)
          @else
           <td>0</td>
          @endif
          @if(!is_null($report->get('مؤجر')))
            <td title="{{ $report->get('مؤجر')[0]->type }}">{{ $report->get('مؤجر')[0]->count }}</td>
            @php($totalCount += $report->get('مؤجر')[0]->count)
          @else
           <td>0</td>
          @endif
          @if(!is_null($report->get('حكومي')))
            <td title="{{ $report->get('حكومي')[0]->type }}">{{ $report->get('حكومي')[0]->count }}</td>
            @php($totalCount += $report->get('حكومي')[0]->count)
          @else
           <td>0</td>
          @endif
          @if(!is_null($report->get('ورثة')))
            <td title="{{ $report->get('ورثة')[0]->type }}">{{ $report->get('ورثة')[0]->count }}</td>
            @php($totalCount += $report->get('ورثة')[0]->count)
          @else
           <td>0</td>
          @endif
          @if(!is_null($report->get('استضافة')))
            <td title="{{ $report->get('استضافة')[0]->type }}">{{ $report->get('استضافة')[0]->count }}</td>
            @php($totalCount += $report->get('استضافة')[0]->count)
          @else
           <td>0</td>
          @endif
          @if(!is_null($report->get('قروي')))
            <td title="{{ $report->get('قروي')[0]->type }}">{{ $report->get('قروي')[0]->count }}</td>
            @php($totalCount += $report->get('قروي')[0]->count)
          @else
           <td>0</td>
          @endif
          @if(!is_null($report->get('رحل')))
            <td title="{{ $report->get('رحل')[0]->type }}">{{ $report->get('رحل')[0]->count }}</td>
            @php($totalCount += $report->get('رحل')[0]->count)
          @else
           <td>0</td>
          @endif
          @if(!is_null($report->get('أخرى')))
            <td title="{{ $report->get('أخرى')[0]->type }}">{{ $report->get('أخرى')[0]->count }}</td>
            @php($totalCount += $report->get('أخرى')[0]->count)
          @else
           <td>0</td>
          @endif
          <td title="المجموع">{{ $totalCount }}</td>
          
				</tr>

				<tr>
					<td>النسبة</td>
            @if(!is_null($report->get('ملك')) && $report->get('ملك')[0]->count > 0 && $totalCount > 0)
              <td>{{ round(($report->get('ملك')[0]->count / $totalCount) * 100, 2) . '%' }}</td>
            @else
              <td>0%</td>
            @endif
            @if(!is_null($report->get('مؤجر')) && $report->get('مؤجر')[0]->count > 0 && $totalCount > 0)
              <td>{{ round(($report->get('مؤجر')[0]->count / $totalCount) * 100, 2) . '%' }}</td>
            @else
              <td>0%</td>
            @endif
            @if(!is_null($report->get('حكومي')) && $report->get('حكومي')[0]->count > 0 && $totalCount > 0)
              <td>{{ round(($report->get('حكومي')[0]->count / $totalCount) * 100, 2) . '%' }}</td>
            @else
              <td>0%</td>
            @endif
            @if(!is_null($report->get('ورثة')) && $report->get('ورثة')[0]->count > 0 && $totalCount > 0)
              <td>{{ round(($report->get('ورثة')[0]->count / $totalCount) * 100, 2) . '%' }}</td>
            @else
              <td>0%</td>
            @endif
            @if(!is_null($report->get('استضافة')) && $report->get('استضافة')[0]->count > 0 && $totalCount > 0)
              <td>{{ round(($report->get('استضافة')[0]->count / $totalCount) * 100, 2) . '%' }}</td>
            @else
              <td>0%</td>
            @endif
            @if(!is_null($report->get('قروي')) && $report->get('قروي')[0]->count > 0 && $totalCount > 0)
              <td>{{ round(($report->get('قروي')[0]->count / $totalCount) * 100, 2) . '%' }}</td>
            @else
              <td>0%</td>
            @endif
            @if(!is_null($report->get('رحل')) && $report->get('رحل')[0]->count > 0 && $totalCount > 0)
              <td>{{ round(($report->get('رحل')[0]->count / $totalCount) * 100, 2) . '%' }}</td>
            @else
              <td>0%</td>
            @endif
            @if(!is_null($report->get('أخرى')) && $report->get('أخرى')[0]->count > 0 && $totalCount > 0)
              <td>{{ round(($report->get('أخرى')[0]->count / $totalCount) * 100, 2) . '%' }}</td>
            @else
              <td>0%</td>
            @endif
            @if($totalCount > 0)
              <td>100%</td>
            @else
              <td>0%</td>
            @endif
				</tr>

			</x-slot:body>

		  </x-table>


      </div>
    </div>

  @include('components.footer')