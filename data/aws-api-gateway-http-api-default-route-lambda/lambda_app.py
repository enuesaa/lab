import json
import logging

logger = logging.getLogger()
logger.setLevel(logging.INFO)

def lambda_handler(event, context):
    logger.info(json.dumps(event, indent=2, ensure_ascii=False))

    print(f"routeKey: {event['routeKey']}")
    print(f"rawPath: {event['rawPath']}")
    print(f"rawQueryString: {event['rawQueryString']}")
    print(f"method: {event['requestContext']['http']['method']}")
    print(f"path: {event['requestContext']['http']['path']}")

    return {
        "statusCode": 200,
        "body": "OK",
    }
