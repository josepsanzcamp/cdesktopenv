#!/usr/dt/bin/dtksh
exec 2>/dev/null

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

DtWsmGetWorkspaceList $display $root workspaces
for workspace in $(echo $workspaces | tr ',' ' '); do
	XmGetAtomName name $display $workspace
	echo $workspace"|"$name
done

