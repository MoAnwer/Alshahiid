@include('components.header', ['page_title' => ' السيرة الذاتية للشهيد  ' . $martyr->name])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')

      
      <div class="container-fluid mt-4">

       <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item">
              <a href="{{ route('martyrs.index') }}">الشهداء</a>
              / 
            </li>
            <li class="breadcrumb-item  mr-1">
              <a href="{{ route('families.show', $martyr->family->id) }}"> اسرة الشهيد {{ $martyr->name}} </a>
            </li>
            <li  class="breadcrumb-item active  mr-1"> السيرة الذاتية للشهيد {{ $martyr->name}} </li>
          </ol>
        </nav>

        <hr />

        <div class="d-flex justify-content-between align-items-center px-3">
        <h4> السيرة الذاتية للشهيد {{ $martyr->name}} </h4>
        @empty($martyr->martyrDoc)
          <a href="{{ route('tazkiia.martyrDocs.create', $martyr->id) }}" class="btn btn-primary active">
            <i class="fa fas-file-plus"></i>
            اضافة سيرة الذاتية
          </a>          
        @endempty
        </div>
        <hr />

      <x-alert/>

        @empty(!$martyr->martyrDoc)
          <h6 class="pb-1 mb-4 text-muted">السيرة الذاتية للشهيد {{ $martyr->name }}</h6>
          <div class="row row-cols-1 row-cols-md-3 g-6 mb-6">
              <div class="col">
              <div class="card h-100 text-center">
                @empty(!$martyr->martyrDoc->storage_path)
                  <a href="{{ asset("uploads/documents/{$martyr->martyrDoc->storage_path}") }}" class="text-center p-3  text-info" target="_blank">
                    <i class="fas fa-file-pdf" style="font-size: 150px"></i>
                  </a>
                @else 
                  <i class="fas fa-file-pdf" style="font-size: 150px" class="text-center p-3 text-danger" title="لا يوجد ملف سيرة ذاتية"></i>
                @endempty
                
                <div class="card-body">
                  <span class="text-secondary">ملاحظات</span>
                  <p class="card-text text-secondary mt-2">
                    {{ $martyr->martyrDoc->notes ?? 'لا يوجد'}}
                  </p>
                  <hr />
                  <a href="{{ route('tazkiia.martyrDocs.edit', $martyr->martyrDoc->id) }}" class="btn btn-success fa-sm p-1">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('tazkiia.martyrDocs.delete', $martyr->martyrDoc->id) }}" class="btn btn-danger fa-sm p-1">
                    <i class="fas fa-trash"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @else
        <h6 class="pb-1 mb-4 text-muted">لا توجد سيرة بعد</h6>    
        @endempty
    </div>
  </div>

  @include('components.footer')