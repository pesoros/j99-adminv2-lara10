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

function getRoleAccess($role_id)
{
    $result = App\Models\Menu::getRoleAccess([
        'role_id' => $role_id
    ]);

    return $result;
}

function checkAccess($accessName)
{
    $result = in_array($accessName, Session('roleaccess_session'));
    return $result;
}