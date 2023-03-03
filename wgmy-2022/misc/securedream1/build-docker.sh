#!/bin/sh

docker build . -t wgmy-secure-dream&& \
docker run --rm --name=wgmy-secure-dream -p50255:50255 wgmy-secure-dream
