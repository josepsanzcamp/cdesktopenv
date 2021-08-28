
all:
	gcc -o dtatom2title dtatom2title.c -I /usr/dt/include -L /usr/dt/lib -lXt -lDtSvc -lDtWidget -ltt -lXm -lX11
	gcc -o dtgetallws dtgetallws.c -I /usr/dt/include -L /usr/dt/lib -lXt -lDtSvc -lDtWidget -ltt -lXm -lX11
	gcc -o dtgetcurws dtgetcurws.c -I /usr/dt/include -L /usr/dt/lib -lXt -lDtSvc -lDtWidget -ltt -lXm -lX11

clean:
	rm -f dtatom2title
	rm -f dtgetallws
	rm -f dtgetcurws
