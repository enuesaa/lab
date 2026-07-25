def lambda_handler(event, context):
    print('routeKey:', event['routeKey'])
    print('rawPath:', event['rawPath'])
    print('queryStringParameters:', event.get('queryStringParameters', ''))
    print('body:', event.get('body', ''))
    print('requestContext.http.method:', event['requestContext']['http']['method'])
    print('requestContext.http.path:', event['requestContext']['http']['path'])

    return {
        "statusCode": 200,
        "body": "OK",
    }