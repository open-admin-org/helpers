
<!-- Chat card -->
<div class="card card-primary">
    <div class="card-header with-border">
        <i class="icon-terminal"></i>
    </div>
    <div class="card-body chat" id="terminal-card">
        <!-- chat item -->

        <!-- /.item -->
    </div>
    <!-- /.chat -->
    <div class="card-footer with-border">

        <div style="margin-bottom: 10px;">

            @foreach($commands['groups'] as $group => $command)

            <div class="btn-group dropup">
                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $group }}
                </button>
                <ul class="dropdown-menu">
                    @foreach($command as $item)
                        <li><a class="dropdown-item loaded-command">{{$item}}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach

            <div class="btn-group dropup">
                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Other
                </button>
                <ul class="dropdown-menu">
                    @foreach($commands['others'] as $item)
                    <li><a class="dropdown-item loaded-command">{{$item}}</a></li>
                    @endforeach
                </ul>
            </div>

            <button type="button" class="btn btn-success" id="terminal-send"><i class="fa fa-paper-plane"></i> send</button>

            <button type="button" class="btn btn-warning" id="terminal-clear"><i class="fa fa-refresh"></i> clear</button>
        </div>

        <div class="input-group">
            <span class="input-group-text px-2">artisan</span>
            <input class="form-control input-lg" id="terminal-query" placeholder="command">
        </div>
    </div>
</div>
@include("open-admin-helpers::_shared")
