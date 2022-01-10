@echo off
chcp 932

rem ----------------------------------------------
rem bat�ł܂Ƃ߂ăe�X�g���s
rem > tests\bin\connect-cms-test.bat
rem
rem [How to test]
rem https://github.com/opensource-workshop/connect-cms/wiki/Dusk
rem ----------------------------------------------

rem �e�X�g�R�}���h���s���ɂP�x�����A�����e�X�gDB������������̂ŕs�v�ł��B
rem   (see) https://github.com/opensource-workshop/connect-cms/wiki/Dusk#�蓮�Ńe�X�gdb������
rem @php artisan config:clear

if "%1" == "db_clear" (
    rem ���L�́A�����e�X�gDB�������ōs���Ă��Ȃ��R�}���h
    echo.
    echo --- �L���b�V���N���A
    php artisan cache:clear
    rem php artisan config:clear

    echo.
    echo --- �f�[�^�x�[�X�E�N���A
    php artisan migrate:fresh --env=dusk.local

    rem echo.
    rem echo --- �f�[�^�E�����ǉ�
    rem php artisan db:seed --env=dusk.local
)

rem ---------------------------------------------
rem - �R�A
rem ---------------------------------------------

echo.
echo --- �y�[�W�Ȃ�(404)
rem php artisan dusk tests\Browser\Core\PageNotFoundTest.php

echo.
echo --- �����Ȃ�(403)
rem php artisan dusk tests\Browser\Core\PageForbiddenTest.php

echo.
echo --- ����m�F���b�Z�[�W����e�X�g
rem php artisan dusk tests\Browser\Core\MessageFirstShowTest.php

echo.
echo --- ����m�F���b�Z�[�W����e�X�g ���ڃt������
rem php artisan dusk tests\Browser\Core\MessageFirstShowFullTest.php

echo.
echo --- �{���p�X���[�h�t�y�[�W�e�X�g
rem php artisan dusk tests\Browser\Core\PagePasswordTest.php

echo.
echo --- ���O�C���e�X�g
rem php artisan dusk tests\Browser\Core\LoginTest.php

rem ---------------------------------------------
rem - �Ǘ��v���O�C��
rem ---------------------------------------------

echo.
echo --- �Ǘ���ʃA�N�Z�X
rem php artisan dusk tests\Browser\Manage\IndexManageTest.php

echo.
echo --- �y�[�W�Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\PageManageTest.php

echo.
echo --- �T�C�g�Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\SiteManageTest.php

echo.
echo --- ���[�U�Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\UserManageTest.php

echo.
echo --- �O���[�v�Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\GroupManageTest.php

echo.
echo --- �Z�L�����e�B�Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\SecurityManageTest.php

echo.
echo --- �v���O�C���Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\PluginManageTest.php

echo.
echo --- �V�X�e���Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\SystemManageTest.php

echo.
echo --- API�Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\ApiManageTest.php

echo.
echo --- ���b�Z�[�W�Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\MessageManageTest.php

echo.
echo --- �O���F�؊Ǘ��̃e�X�g
rem php artisan dusk tests\Browser\Manage\AuthManageTest.php

rem ---------------------------------------------
rem - ��ʃv���O�C��
rem ---------------------------------------------

echo.
echo --- �w�b�_�[
php artisan dusk tests\Browser\User\HeaderAreaTest.php

echo.
echo --- �u���O
rem php artisan dusk tests\Browser\User\BlogTest.php

echo.
echo �� �X�N���[���V���b�g�̕ۑ���
echo tests\Browser\screenshots
