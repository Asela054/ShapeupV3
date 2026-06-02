# Privilege System - Architecture Diagram

## System Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                         USER REQUEST                             │
│                    (e.g., /customer/create)                      │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│                   LARAVEL AUTHENTICATION                         │
│                      (Auth Middleware)                           │
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Is user authenticated?                                    │  │
│  │  ├─ YES → Continue                                        │  │
│  │  └─ NO  → Redirect to login                              │  │
│  └──────────────────────────────────────────────────────────┘  │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│                 PRIVILEGE MIDDLEWARE CHECK                       │
│              (CheckPrivilege::class - middleware)                │
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Extract menuId and action from middleware parameter       │  │
│  │ Example: privilege:7,add                                  │  │
│  │  ├─ menuId = 7 (Customer)                                │  │
│  │  └─ action = 'add'                                        │  │
│  └──────────────────────────────────────────────────────────┘  │
│                            │                                     │
│                            ▼                                     │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Call PrivilegeService::check(7, 'add')                    │  │
│  └──────────────────────────────────────────────────────────┘  │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│                     PRIVILEGE SERVICE                            │
│                  (PrivilegeService::class)                       │
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Get authenticated user                                    │  │
│  │ $user = Auth::user();                                     │  │
│  └──────────────────────────────────────────────────────────┘  │
│                            │                                     │
│                            ▼                                     │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Call $user->hasPrivilege(7, 'add')                        │  │
│  └──────────────────────────────────────────────────────────┘  │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│                        USER MODEL                                │
│                      (User::class)                               │
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Query tbl_user_privilege table:                           │  │
│  │                                                            │  │
│  │ SELECT * FROM tbl_user_privilege                          │  │
│  │ WHERE tbl_user_idtbl_user = {userId}                      │  │
│  │   AND tbl_menu_list_idtbl_menu_list = 7                   │  │
│  │   AND access_status = 1                                   │  │
│  │   AND status = 1                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                            │                                     │
│                            ▼                                     │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Check 'add' column value:                                 │  │
│  │  ├─ add = 1 → Return TRUE                                │  │
│  │  └─ add = 0 → Return FALSE                               │  │
│  └──────────────────────────────────────────────────────────┘  │
└───────────────────────────┬─────────────────────────────────────┘
                            │
              ┌─────────────┴─────────────┐
              │                           │
              ▼ TRUE                      ▼ FALSE
┌────────────────────────────┐  ┌──────────────────────────────┐
│     ALLOW ACCESS            │  │      DENY ACCESS              │
│                             │  │                               │
│  Continue to Controller     │  │  Return 403 Response          │
│           │                 │  │  "Unauthorized action"        │
│           ▼                 │  │  Redirect back with error     │
│  ┌──────────────────────┐  │  └──────────────────────────────┘
│  │ Controller Method    │  │
│  │ (e.g., store())      │  │
│  │                      │  │
│  │ Additional checks    │  │
│  │ authorizePrivilege() │  │
│  │ (optional)           │  │
│  └──────────┬───────────┘  │
│             │              │
│             ▼              │
│  ┌──────────────────────┐  │
│  │ Process Request      │  │
│  │ (Save to DB, etc.)   │  │
│  └──────────┬───────────┘  │
│             │              │
│             ▼              │
│  ┌──────────────────────┐  │
│  │ Return View          │  │
│  │ with privilege data  │  │
│  └──────────┬───────────┘  │
└─────────────┼──────────────┘
              │
              ▼
┌─────────────────────────────────────────────────────────────────┐
│                         BLADE VIEW                               │
│                  (e.g., customer.index.blade.php)                │
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Privilege data available via:                             │  │
│  │  1. $privileges array from controller                     │  │
│  │  2. Helper functions: checkPrivilege(), canAccessMenu()   │  │
│  │  3. PrivilegeComposer: $accessibleMenus                   │  │
│  └──────────────────────────────────────────────────────────┘  │
│                            │                                     │
│                            ▼                                     │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ Conditional rendering:                                    │  │
│  │                                                            │  │
│  │ @if(checkPrivilege(7, 'add'))                             │  │
│  │     <button>Add Customer</button>                         │  │
│  │ @endif                                                    │  │
│  │                                                            │  │
│  │ @if(checkPrivilege(7, 'edit'))                            │  │
│  │     <button>Edit</button>                                 │  │
│  │ @endif                                                    │  │
│  │                                                            │  │
│  │ @if(checkPrivilege(7, 'remove'))                          │  │
│  │     <button>Delete</button>                               │  │
│  │ @endif                                                    │  │
│  └──────────────────────────────────────────────────────────┘  │
│                            │                                     │
│                            ▼                                     │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ JavaScript access:                                        │  │
│  │                                                            │  │
│  │ const privileges = @json($privileges);                    │  │
│  │                                                            │  │
│  │ if (privileges.add) {                                     │  │
│  │     // Enable add functionality                           │  │
│  │ }                                                         │  │
│  └──────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
```

## Database Schema

```
┌────────────────────┐
│     tbl_user       │
├────────────────────┤
│ idtbl_user (PK)    │
│ name               │
│ username           │
│ password           │
│ tbl_user_type_id ──┼──┐
└────────────────────┘  │
         │              │
         │ 1:N          │ N:1
         │              │
         ▼              │
┌────────────────────┐  │     ┌──────────────────┐
│ tbl_user_privilege │  │     │  tbl_user_type   │
├────────────────────┤  │     ├──────────────────┤
│ idtbl_user_pri(PK) │  │     │ idtbl_user_type  │
│ add (0/1)          │  └────▶│ type             │
│ edit (0/1)         │        │ status           │
│ statuschange (0/1) │        └──────────────────┘
│ remove (0/1)       │
│ access_status(0/1) │
│ status (0/1)       │
│ tbl_user_id ───────┘
│ tbl_menu_list_id ──┼──┐
└────────────────────┘  │
                        │ N:1
                        │
                        ▼
                ┌──────────────────┐
                │  tbl_menu_list   │
                ├──────────────────┤
                │ idtbl_menu_list  │
                │ menu_name        │
                │ menu_url         │
                │ menu_icon        │
                │ status           │
                └──────────────────┘
```

## Component Interaction

```
┌──────────────┐
│   Routes     │ ──middleware('privilege:menuId,action')──┐
└──────────────┘                                          │
                                                          ▼
┌──────────────┐                              ┌────────────────────┐
│ Controllers  │ ──authorizePrivilege()────▶  │ CheckPrivilege     │
└──────────────┘                              │ Middleware         │
       │                                       └─────────┬──────────┘
       │ Pass $privileges                                │
       ▼                                                 │
┌──────────────┐                                        │
│ Blade Views  │ ──checkPrivilege()──┐                  │
└──────────────┘                     │                  │
       │                             ▼                  ▼
       │                     ┌───────────────────────────────┐
       └────canAccessMenu()─▶│   PrivilegeService            │
                             │   (Business Logic)            │
                             └───────────┬───────────────────┘
                                         │
                                         ▼
                             ┌───────────────────────────────┐
                             │   User Model                   │
                             │   (Database Queries)           │
                             └───────────┬───────────────────┘
                                         │
                                         ▼
                             ┌───────────────────────────────┐
                             │   tbl_user_privilege          │
                             │   (Database Table)            │
                             └───────────────────────────────┘
```

## Security Layers

```
Layer 1: Route Middleware
├─ Blocks unauthorized requests before reaching controller
├─ Checks menu access and specific actions
└─ Returns 403 if no permission

Layer 2: Controller Authorization
├─ Double-checks privileges in controller methods
├─ Allows custom error handling
└─ Can combine multiple privilege checks

Layer 3: View Directives
├─ Hides UI elements based on privileges
├─ Improves user experience
└─ NOT a security layer (can be bypassed)
```

## Privilege Check Decision Tree

```
User attempts action
        │
        ▼
    Is authenticated?
    ├─ NO  → Redirect to login
    │
    └─ YES
        │
        ▼
    Has menu access?
    (access_status = 1, status = 1)
    ├─ NO  → 403 Unauthorized
    │
    └─ YES
        │
        ▼
    Is specific action required?
    ├─ NO  → Allow (just viewing)
    │
    └─ YES
        │
        ▼
    Check action column
    (add/edit/statuschange/remove)
    ├─ Column = 1 → Allow
    └─ Column = 0 → 403 Unauthorized
```

## Legacy vs New System Comparison

```
LEGACY SYSTEM (menubar.php)
┌─────────────────────────┐
│ PHP includes checkpri() │
│ function in every page  │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ Checks privilege in DB  │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ Sets JS variables       │
│ ($addcheck, $editcheck) │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ JavaScript hides buttons│
│ ⚠️ PAGE STILL ACCESSIBLE│
└─────────────────────────┘

NEW LARAVEL SYSTEM
┌─────────────────────────┐
│ Middleware on route     │
│ (privilege:menuId,...)  │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ PrivilegeService checks │
│ database permissions    │
└────────┬────────────────┘
         │
    NO   │  YES
    ◄────┼────►
         │         │
         ▼         ▼
┌─────────────┐  ┌──────────────────┐
│ 403 Block   │  │ Allow Controller │
│ ✅ SECURE    │  │ Pass privileges  │
└─────────────┘  └────────┬─────────┘
                          │
                          ▼
                 ┌──────────────────┐
                 │ View hides       │
                 │ buttons (UX)     │
                 └──────────────────┘
```
