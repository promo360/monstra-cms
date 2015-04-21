/**
 * Promo JS module
 *
 * This source file is part of the Promo Engine. More information,
 * documentation and tutorials can be found at http://cms.promo360.ru
 *
 * @package     Promo
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/* Confirm delete */
function confirmDelete(msg){var data=confirm(msg+" ?"); return data;}

/* Messanger */
Messenger.options = {
    extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
    theme: 'flat'
}