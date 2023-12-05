<?php

function getUserRoleInfo($email, $onlyParent = false)
{
    $result = App\Models\Menu::getUserRoleInfo(['email' => $email]);
    return $result;
}

function getMenu($role_id, $onlyParent = false)
{
    $result = $role_id !== 1 ? App\Models\Menu::getMenuWithRole(['role_id' => $role_id]) : App\Models\SuperUser::getMenuSU();

    if (!$onlyParent) {
        foreach ($result as $key => $value) {
            $child = getChildMenu($value->id, $role_id);
            if (!$child->isEmpty()) {
                $value->child = $child;
            }
        }
    }

    return $result;
}

function getChildMenu($parent_id, $role_id)
{
    if ($role_id !== 1 ) {
        $result = App\Models\Menu::getChildMenu([
            'parent_id' => $parent_id,
            'role_id' => $role_id
        ]);
    } else {
        $result = App\Models\SuperUser::getChildMenuSU([
            'parent_id' => $parent_id,
        ]);
    }

    return $result;
}

function getRoleAccessData($role_id)
{
    if ($role_id !== 1 ) {
        $result = App\Models\Role::getRoleAccess([
            'role_id' => $role_id
        ]);
    } else {
        $result = App\Models\SuperUser::getRoleAccess();
    }

    return $result;
}

function getModuleUrl()
{
    return request()->segment(2) ? request()->segment(2) : request()->segment(1);
}

function permissionCheck($access, $directModule = '')
{
    $permissionData = Session('roleaccess_session');
    $module = $directModule ? $directModule : getModuleUrl();
    return in_array($module.' '.$access, $permissionData);
}