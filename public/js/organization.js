/**
 * Open a modal overlay by its ID.
 */
function openModal(id) {
    document.getElementById(id).classList.add('active');
}

/**
 * Close a modal overlay by its ID.
 */
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}

/**
 * Close any modal when clicking outside the modal box.
 */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });
});

/**
 * Show the confirm-delete modal.
 * @param {string} url    - The DELETE route URL.
 * @param {string} msg    - Confirmation message to display.
 */
function confirmAction(url, msg) {
    document.getElementById('confirmActionMsg').textContent = msg;
    document.getElementById('confirmActionForm').action = url;
    openModal('confirmActionModal');
}

/**
 * Populate and open the Edit Bank modal.
 * @param {number} id
 * @param {string} name
 * @param {string} code
 * @param {string} baseUrl  - e.g. '/organization/bank'
 */
function openEditBankModal(id, name, code, baseUrl) {
    document.getElementById('editBankForm').action = baseUrl + '/' + id;
    document.getElementById('editBankName').value  = name;
    document.getElementById('editBankCode').value  = code;
    openModal('editBankModal');
}

/**
 * Populate and open the Edit Bank Branch modal.
 * @param {number} id
 * @param {string} code
 * @param {string} branch
 * @param {string} baseUrl  - e.g. '/organization/bank-branch'
 */
function openEditBranchModal(id, code, branch, baseUrl) {
    document.getElementById('editBranchForm').action = baseUrl + '/' + id;
    document.getElementById('editBranchCode').value  = code;
    document.getElementById('editBranchName').value  = branch;
    openModal('editBranchModal');
}

/**
 * Toggle custom OT rate fields based on radio selection.
 * Called on DOMContentLoaded and on change events.
 */
function initOtTypeToggles() {
    var satRadios = document.querySelectorAll('input[name="saturday_ot_type"]');
    var sunRadios = document.querySelectorAll('input[name="sunday_ot_type"]');
    var satDiv    = document.getElementById('customSaturdayRate');
    var sunDiv    = document.getElementById('customSundayRate');

    satRadios.forEach(function (el) {
        el.addEventListener('change', function () {
            if (satDiv) satDiv.style.display = (this.value === 'Custom') ? 'block' : 'none';
        });
    });
    sunRadios.forEach(function (el) {
        el.addEventListener('change', function () {
            if (sunDiv) sunDiv.style.display = (this.value === 'Custom') ? 'block' : 'none';
        });
    });
}

document.addEventListener('DOMContentLoaded', initOtTypeToggles);

/**
 * Standard DataTables button config (reusable).
 */
var dtButtons = [
    {
        extend: 'csv',
        text: '&#128196; CSV',
        className: 'dt-btn dt-btn-green',
        exportOptions: { columns: ':not(:last-child)' }
    },
    {
        extend: 'pdf',
        text: '&#128196; PDF',
        className: 'dt-btn dt-btn-red',
        exportOptions: { columns: ':not(:last-child)' }
    },
    {
        extend: 'print',
        text: '&#128424; Print',
        className: 'dt-btn dt-btn-blue',
        exportOptions: { columns: ':not(:last-child)' }
    }
];