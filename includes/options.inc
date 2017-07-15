<div class="option-panel is-block animated is-hidden" id="options-panel">
    <header class="modal-card-head">
        <h1 class="modal-card-title has-text-centered">Options</h1>
        <button type="button" class="delete" onclick="show('options-panel', 'fromright')"></button>
    </header>
    <div class="panel-tabs">
        <a class="label is-marginless is-active">Clients</a>
        <a class="label is-marginless">Account</a>
    </div>
<a class="panel-block" onclick="clearlocal()">
  <span class="icon"><i class="fa fa-pencil" aria-hidden="true"></i>
  </span>
  <p class="subtitle">Edit Client</p>
</a>
<a class="panel-block" onclick="generateClientList();show('all-clients-panel', 'fromtop')">
  <span class="icon"><i class="fa fa-address-book" aria-hidden="true"></i>
  </span>
  <p class="subtitle">View Clients</p>
</a>
</div>