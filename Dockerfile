FROM ubuntu:latest
LABEL authors="adrienkouyate"

ENTRYPOINT ["top", "-b"]
