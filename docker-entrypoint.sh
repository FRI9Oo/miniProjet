#!/bin/bash
set -e

# Fix MPM at runtime, after any platform overlay
rm -f /etc/apache2/mods-enabled/mpm_*.load
rm -f /etc/apache2/mods-enabled/mpm_*.conf

ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load

# mpm_prefork.conf may not exist, only link if it does
if [ -f /etc/apache2/mods-available/mpm_prefork.conf ]; then
    ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf
fi

exec "$@"