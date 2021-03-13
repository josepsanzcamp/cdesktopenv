#!/usr/dt/bin/dtksh
exec 2>/dev/null

XtInitialize TOP a b
XtDisplay display $TOP
XtScreen screen $TOP
XRootWindowOfScreen root $screen

#~ DtWsmGetWorkspaceList $display $root workspaces
workspaces=$(./dtgetallws)
for workspace in $(echo $workspaces | tr ',' ' '); do
	./dtatom2title $workspace
done

