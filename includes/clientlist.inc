<form class="modal is-block animated is-hidden" id="all-clients-panel">
 <div class="modal animated client-edit-close-box" id="confirm-delete-modal">
    <div class="message is-danger has-text-centered">
        <div class="message-header">
          <h1 class="">Delete Client?</h1>
        </div>
        <div class="message-body">
          <p class="has-text-danger">This will also delete any logs for this client</p>
          <button class="button" type="button" onclick="delClient()" id="confirm-close" value="Yes">Yes</button>
          <button class="button" type="button" onclick="dontDel()">No</button>
        </div>
    </div>
</div>
 <div class="modal-background"></div>
  <div class="modal-card animated">
    <header class="modal-card-head">
      <h1 class="modal-card-title has-text-centered">Clients</h1>
      <button type="button" class="delete" onclick="show('all-clients-panel', 'fromtop')"></button>
    </header>
      <div class="" id="sort-row">
        <p class="">Sort by:</p>
        <a class="button is-link">Name</a><a class="button is-link">New</a><a class="button is-link">Recent</a>
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