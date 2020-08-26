# cdesktopenv
This resository contains some useful scripts (developed by me, more or less) used by me to add features to my CDE that runs on my laptop with GNU/Linux!!!
- If you want more info about de CDE and how to use it in GNU/Linux, go to the sourceforge project: https://sourceforge.net/projects/cdesktopenv/

![cdesktopenv](https://a.fsdn.com/con/app/proj/cdesktopenv/screenshots/CDE-6.png)

# dtswitch
This folder contains 4 dtksh scripts intended to interact with the CDE:
- dtgetallws.sh => returns all workspaces
- dtgetcurws.sh => returns the current workspace
- dtmovews.sh => move a window to the specified workspace
- dtsetws.sh => set the specified workspace
- dtswitch.php => this is the brain of the system, this script can get the follow parameters:
  - One, Two, Three, Four => to move to the specified workspace
  - Up, Down, Left, Right => to move to the next workspace depending the current workspace
  - Up2, Down2, Left2, Right2 => to move the active window to the next workspace using the previous logics

# others
This folder contains some useful scripts and extra files to setup the xbindkeys, for example:
- myamixer => this script allow me to control the audio settings
- mybrightness => this script allow me to control the brightness of the laptop screen
- mydtswitch => this script allow me to use the hotkeys to move between the diferent workspaces
- myxterm => this script only open an xterm usign the Xresources file
- xbindkeysrc => this configuration file allow me to configure the xbindkeys daemon
- Xresources => this configuration file allow me to have the xterm and other defaults defined here


