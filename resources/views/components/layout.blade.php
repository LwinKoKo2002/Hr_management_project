<x-header :title="$title" />
<div class="page-wrapper chiller-theme toggled">
    <section id="app">
        @auth
        <x-sidebar />
        <x-header_menu :title="$title" />
        @endauth
        <main class="py-4">
            <div class="main-content">
                <div class="d-flex justify-content-center">
                    <div class="col-md-10">
                        {{$slot}}
                    </div>
                </div>
            </div>
        </main>
        @auth
        <x-bottom_menu />
        @endauth
    </section>
</div>
<x-footer :script="$script" />