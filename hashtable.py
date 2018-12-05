file = open("input.txt", "r")
keys = []

numSearchKeys = int(file.readline())
numBuckets = int(file.readline())
numRecords = int(file.readline())

for key in file.readline().split():
    keys.append(key)

buckets = [None] * numBuckets

def hash(val):
    hash = 0
    for i in range(len(val)):
        hash += ord(val[i]) * 11 ** i
    return hash % numBuckets

def insert(val):
    if buckets[hash(val)] == None:
        list = []
        list.append(val)
        buckets[hash(val)] = list
    elif val not in buckets[hash(val)] and len(buckets[hash(val)]) < numRecords:
        buckets[hash(val)].append(val)

for key in keys:
    insert(key)

print(buckets)