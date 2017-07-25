<form class="modal is-block  animated" id="all-clients-panel">
<div class="modal-background"></div>
  <div class="modal-card animated">
    <header class="modal-card-head">
      <h1 class="modal-card-title has-text-centered">Clients</h1>
      <button type="button" class="delete" onclick="show('all-clients-panel', 'fromtop')"></button>
    </header>
    <div class="message is-light" id="sort-row">
      <span class="message-header" id="sort-row"><p class="">Sort by:</p>
        <a class="">Name</a><a class="">New</a><a class="">Recent</a>
      </span>
    </div>
    <section class="modal-card-body">
      <div class="panel" id="all-clients-container">
      </div>
    </section>
    <footer class="modal-card-foot">
      <button type="button" class="button green" id="add-client-button" onclick="show('all-clients-panel', 'fromtop');show('client-details', 'fromtop')">New Client</button>
      <button type="button" class="button red" onclick="show('all-clients-panel', 'fromtop')">Close</button>
    </footer>
  </div>
</form>