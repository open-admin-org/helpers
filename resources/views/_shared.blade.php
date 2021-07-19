<style>

    #terminal-card{
        height: calc(100% - 247px);
        overflow:auto;
    }
    #terminal-card pre{

        background:#F1f1f1;
        color:#000;
        padding:8px;
        margin-bottom:6px;
    }
    #terminal-card .item{
        margin: 0 0 6px 0;
    }
</style>

<script>
    (function () {

        let storageKey = function () {
            if (document.getElementById('connections')){
                var connection = document.getElementById('connections').value;
                return 'la-'+connection+'-history';
            }
        };

        document.getElementById('terminal-card').style.height = (window.innerHeight - 290)+"px";

        function History () {
            this.index = this.count() - 1;
        }

        History.prototype.store = function () {
            var history = localStorage.getItem(storageKey());
            if (!history) {
                history = [];
            } else {
                history = JSON.parse(history);
            }
            return history;
        };

        History.prototype.push = function (record) {
            var history = this.store();
            history.push(record);
            localStorage.setItem(storageKey(), JSON.stringify(history));

            this.index = this.count() - 1;
        };

        History.prototype.count = function () {
            return this.store().length;
        };

        History.prototype.up = function () {
            if (this.index > 0) {
                this.index--;
            }

            return this.store()[this.index];
        };

        History.prototype.down = function () {
            if (this.index < this.count() - 1) {
                this.index++;
            }

            return this.store()[this.index];
        };

        History.prototype.clear = function () {
            localStorage.removeItem(storageKey());
        };

        let history = new History;

        let send = function () {

            let terminal_query = document.getElementById('terminal-query');
            let url = location.pathname
            let data = {};

            if (document.getElementById('connections')) {
                // yes when connection page is database queries
                let connection = document.getElementById('connections').value;
                data = {
                    c: connection,
                    q: terminal_query.value,
                    _token: LA.token
                }
            }else {
                //now we do the terminal part
                data = {
                    c: terminal_query.value,
                    _token: LA.token
                }
            }
            admin.ajax.post(url,data,function(response){

                history.push(terminal_query.value);

                let terminal_card = document.getElementById('terminal-card');
                terminal_card.innerHTML += '<div class="item"><small class="label label-default"> > artisan '+terminal_query.value+'<\/small><\/div>';
                terminal_card.innerHTML += '<div class="item">'+response.data+'<\/div>';
                // fix scroll to end

                terminal_card.scrollTop = terminal_card.scrollHeight;

                terminal_query.value = '';

            });
        };

        let terminal_query = document.getElementById('terminal-query');
        terminal_query.addEventListener("keyup",function(e){

            e.preventDefault();

            if (e.keyCode == 13) {
                send();
            }

            if (e.keyCode == 38) {
                this.value = history.up();
            }

            if (e.keyCode == 40) {
                this.value = history.down();
            }
        });

        document.getElementById('terminal-clear').addEventListener('click',function () {
            document.getElementById('terminal-card').innerHTML = '';
            //history.clear();
        });

        let commands = document.getElementsByClassName('loaded-command');
        for (let command of commands) {
            command.addEventListener('click',function (e) {

                document.getElementById('terminal-query').value = (e.target.innerText + ' ');
                document.getElementById('terminal-query').focus();
            });
        };

        document.getElementById('terminal-send').addEventListener('click',function () {
            send();
        });

    })();

</script>
