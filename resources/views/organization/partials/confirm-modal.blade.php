<div class="modal-overlay" id="confirmActionModal">
    <div class="modal-box" style="max-width:420px; text-align:center; padding:40px 30px;">
        <div style="width:60px; height:60px; border-radius:50%; border:3px solid #f5a623;
                    display:flex; align-items:center; justify-content:center;
                    margin:0 auto 20px; font-size:1.8rem; color:#f5a623;">!</div>
        <h3 style="font-size:1.3rem; margin-bottom:8px;">Are you sure?</h3>
        <p id="confirmActionMsg" style="color:#718096; margin-bottom:24px;"></p>
        <form id="confirmActionForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-confirm">Confirm</button>
            <button type="button" class="btn-cancel"
                    onclick="closeModal('confirmActionModal')">Cancel</button>
        </form>
    </div>
</div>