<?php

/*
 * This file is part of the package buepro/pizpalue.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\Pizpalue\Slot;

class ExtensionInstallUtility
{

    /**
     * Comment the dependency to extension user_customer.
     * The object is just to install user_customer once on the system.
     *
     * @param $extensionKey
     */
    public function afterExtensionInstall($extensionKey)
    {
        if ($extensionKey !== 'pizpalue') {
            return;
        }

        if (class_exists(\TYPO3\CMS\Core\Core\Environment::class)) {
            $emconfFile = TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3conf/ext/pizpalue/ext_emconf.php';
        } else {
            // Fallback for TYPO3 V8
            // @extensionScannerIgnoreLine
            $emconfFile = PATH_site . 'typo3conf/ext/pizpalue/ext_emconf.php';
        }

        $content = file_get_contents($emconfFile);
        $commentToken = '// commented by install process';
        if (strstr($content, $commentToken) === false) {
            $content = str_replace("'user_customer'", $commentToken . " 'user_customer'", $content);
            file_put_contents($emconfFile, $content);
        }
        return;
    }
}
